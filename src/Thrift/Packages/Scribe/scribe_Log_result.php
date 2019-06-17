<?php

namespace Scribe;

use Thrift\Type\TType;

class scribe_Log_result {
	static $_TSPEC;

	public $success = null;

	public function __construct($vals=null) {
		if (!isset(self::$_TSPEC)) {
			self::$_TSPEC = array(
				0 => array(
					'var' => 'success',
					'type' => TType::I32,
				),
			);
		}
		if (is_array($vals)) {
			if (isset($vals['success'])) {
				$this->success = $vals['success'];
			}
		}
	}

	public function getName() {
		return 'scribe_Log_result';
	}

	public function read($input)
	{
		$xfer = 0;
		$fname = null;
		$ftype = 0;
		$fid = 0;
		$xfer += $input->readStructBegin($fname);
		while (true)
		{
			$xfer += $input->readFieldBegin($fname, $ftype, $fid);
			if ($ftype == TType::STOP) {
				break;
			}
			switch ($fid)
			{
				case 0:
					if ($ftype == TType::I32) {
						$xfer += $input->readI32($this->success);
					} else {
						$xfer += $input->skip($ftype);
					}
					break;
				default:
					$xfer += $input->skip($ftype);
					break;
			}
			$xfer += $input->readFieldEnd();
		}
		$xfer += $input->readStructEnd();
		return $xfer;
	}

	public function write($output) {
		$xfer = 0;
		$xfer += $output->writeStructBegin('scribe_Log_result');
		if ($this->success !== null) {
			$xfer += $output->writeFieldBegin('success', TType::I32, 0);
			$xfer += $output->writeI32($this->success);
			$xfer += $output->writeFieldEnd();
		}
		$xfer += $output->writeFieldStop();
		$xfer += $output->writeStructEnd();
		return $xfer;
	}

}
