<?php

namespace Scribe;

use Thrift\Type\TMessageType;

class scribeClient extends FacebookServiceClient implements scribeIf {
	public function __construct($input, $output=null) {
		parent::__construct($input, $output);
	}

	public function Log($messages)
	{
		$this->send_Log($messages);
		return $this->recv_Log();
	}

	public function send_Log($messages)
	{
		$args = new scribe_Log_args();
		$args->messages = $messages;
		$bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
		if ($bin_accel)
		{
			thrift_protocol_write_binary($this->output_, 'Log', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
		}
		else
		{
			$this->output_->writeMessageBegin('Log', TMessageType::CALL, $this->seqid_);
			$args->write($this->output_);
			$this->output_->writeMessageEnd();
			$this->output_->getTransport()->flush();
		}
	}

	public function recv_Log()
	{
		$bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
		if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\scribe_Log_result', $this->input_->isStrictRead());
		else
		{
			$rseqid = 0;
			$fname = null;
			$mtype = 0;

			$this->input_->readMessageBegin($fname, $mtype, $rseqid);
			if ($mtype == TMessageType::EXCEPTION) {
				$x = new TApplicationException();
				$x->read($this->input_);
				$this->input_->readMessageEnd();
				throw $x;
			}
			$result = new scribe_Log_result();
			$result->read($this->input_);
			$this->input_->readMessageEnd();
		}
		if ($result->success !== null) {
			return $result->success;
		}
		throw new \Exception("Log failed: unknown result");
	}

}
