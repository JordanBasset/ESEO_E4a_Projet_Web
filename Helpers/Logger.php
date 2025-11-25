<?php

namespace Helpers;

readonly class Logger {
	private const string LOG_FILE_FORMAT = 'mihoyo-%04d-%02d.log';

	public function __construct(private string $logDir) {
	}

	public function log(bool $success, string $actionType, string $entity, string $message): void {
		$logFile = sprintf(self::LOG_FILE_FORMAT, date('Y'), date('m'));
		$logPath = $this->logDir . DIRECTORY_SEPARATOR . $logFile;
		$this->ensureLogFileExists($logPath);

		$logMessage = sprintf(
			'[%s] [%s][%s] %s: %s',
			date('Y-m-d H:i:s'),
			$actionType, $entity, $success ? 'SUCCESS' : 'ERROR', $message
		);
		if ($fp = fopen($logPath, 'ab')) {
			fwrite($fp, $logMessage . PHP_EOL);
			fclose($fp);
		}
	}

	private function ensureLogFileExists(string $logPath): void {
		if (!file_exists($this->logDir) && !mkdir($this->logDir, 0755, true)) {
			throw new \RuntimeException("Could not create logs directory: $this->logDir");
		}

		if (!file_exists($logPath)) {
			touch($logPath);
			chmod($logPath, 0644);
		}
	}
}
