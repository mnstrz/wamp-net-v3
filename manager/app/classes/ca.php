<?php

namespace App\Classes;

class CA
{
	/* Common Name on root ca certificate */
	private static $_caCN = "Wamp.NET Local Root CA";

	/* Path where CA files will be stored */
	private static $_caPath = null;

	/* Path to config file */
	private static $_caConfig = null;

	public function __construct(string $caPath)
	{
		if (!is_dir($caPath))
			mkdir($caPath);

		if (!is_writable($caPath))
			throw new Exception("Can't write to CA Path");

		static::$_caPath   = $caPath;
		static::$_caConfig = static::$_caPath."\\ca.cnf";

		if (!(file_exists(static::$_caPath."\\ca.key") && file_exists(static::$_caPath."\\ca.crt")))
		{
			$opensslTempConf = "[ req ]\n";
			$opensslTempConf .= "distinguished_name = dn\n";
			$opensslTempConf .= "x509_extensions = v3_ca\n";
			$opensslTempConf .= "\n";
			$opensslTempConf .= "[ dn ]\n";
			$opensslTempConf .= "\n";
			$opensslTempConf .= "[ v3_ca ]\n";
			$opensslTempConf .= "subjectKeyIdentifier = hash\n";
			$opensslTempConf .= "authorityKeyIdentifier = keyid:always,issuer\n";
			$opensslTempConf .= "basicConstraints = critical, CA:true\n";
			$opensslTempConf .= "keyUsage = critical, digitalSignature, cRLSign, keyCertSign";

			file_put_contents(static::$_caConfig, $opensslTempConf);

			$configArgs = ["digest_alg"=>"sha256", "config"=>static::$_caConfig];

			$ca_key = $this->_generateKey(2048);

			file_put_contents(static::$_caPath."\\ca.key", $ca_key);

			$req_csr = openssl_csr_new(["commonName" => static::$_caCN], $ca_key, $configArgs);

			$res = openssl_csr_sign($req_csr, NULL, $ca_key, 7300, $configArgs, time()-1);

			openssl_x509_export($res, $ca_crt);

			file_put_contents(static::$_caPath."\\ca.crt", $ca_crt);

			$this->updateTrustedRoot();
		}
	}

	public function __destruct()
	{
		unlink(static::$_caConfig);
	}

	public function updateTrustedRoot()
	{
		exec('certutil -delstore -enterprise root "'.static::$_caCN.'"');
		exec("certutil -addstore -enterprise -f -v root ".static::$_caPath.'\\ca.crt');
	}

	private function _generateKey(int $bits)
	{
		$configArgs = ['private_key_bits' => $bits, 'config' => static::$_caConfig];
		$res = openssl_pkey_new($configArgs);
		openssl_pkey_export($res, $key, NULL, $configArgs);
		return $key;
	}

	public function generate($domain, $aliases, &$key, &$crt)
	{
		$opensslTempConf  = "[ req ]\n";
		$opensslTempConf .= "x509_extensions = usr_cert\n";
		$opensslTempConf .= "distinguished_name = dn\n";
		$opensslTempConf .= "\n";
		$opensslTempConf .= "[ dn ]\n";
		$opensslTempConf .= "\n";
		$opensslTempConf .= "[ usr_cert ]\n";
		$opensslTempConf .= "subjectAltName = @alt_names\n";
		$opensslTempConf .= "\n";
		$opensslTempConf .= "[ alt_names ]\n";
		$opensslTempConf .= "DNS.1 = $domain";

		$counter = 2;

		foreach ($aliases as $alias)
		{
			$opensslTempConf .= "\nDNS.$counter = $alias.$domain";
			$counter++;
		}

		file_put_contents(static::$_caConfig, $opensslTempConf);

		$configArgs = ['digest_alg'=>'sha256', 'config' => static::$_caConfig];

		$key = $this->_generateKey(2048);

		$req_csr = openssl_csr_new(["commonName" => "$domain"], $key, $configArgs);

		$ca_key = file_get_contents(static::$_caPath."\\ca.key");
		$ca_crt = file_get_contents(static::$_caPath."\\ca.crt");

		$res = openssl_csr_sign($req_csr, $ca_crt, $ca_key, 3650, $configArgs, time());

		openssl_x509_export($res, $crt);

		$this->updateTrustedRoot();
	}
}