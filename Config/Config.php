<?php

namespace Config;

class Config {
	private static ?array $parameters = null;

	/**
	 * Retrieves the configuration value for the given name or returns `$defaultValue` if not found.
	 *
	 * @param $name string configuration value name
	 * @param $defaultValue mixed default value to use if the configuration value is not found
	 * @return mixed
	 */
	public static function get(string $name, mixed $defaultValue = null): mixed {
		return self::getParameters()[$name] ?? $defaultValue;
	}

	// Returns configuration values, loading them from the config file if necessary.
	private static function getParameters(): array {
		if (self::$parameters === null) {
			$configFilePath = 'Config/prod.ini';
			if (!file_exists($configFilePath)) {
				$configFilePath = 'Config/dev.ini';
			}
			if (!file_exists($configFilePath)) {
				throw new \RuntimeException('No configuration file found');
			}

			self::$parameters = parse_ini_file($configFilePath)
				?: throw new \RuntimeException('Unable to load configuration file');
		}

		return self::$parameters;
	}
}
