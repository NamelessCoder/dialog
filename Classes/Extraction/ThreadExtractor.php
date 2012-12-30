<?php
class Tx_Dialog_Extraction_ThreadExtractor extends Tx_Dialog_Extraction_AbstractExtractor implements Tx_Notify_Extraction_ExtractorInterface {

	/**
	 * @var Tx_Dialog_Domain_Repository_ThreadRepository
	 */
	protected $threadRepository;

	/**
	 * @param Tx_Dialog_Domain_Repository_ThreadRepository $threadRepository
	 * @return void
	 */
	public function injectThreadRepository(Tx_Dialog_Domain_Repository_ThreadRepository $threadRepository) {
		$this->threadRepository = $threadRepository;
	}

	/**
	 * @param array $record
	 * @return string
	 */
	public function extractContentFromRecord(array $record) {
		/** @var $thread Tx_Dialog_Domain_Model_Thread */
		$thread = $this->threadRepository->findByUid($record['uid']);
		return $thread->getPosts()->current()->getContent();
	}

	/**
	 * @param array $record
	 * @return string
	 */
	public function extractTitleFromRecord(array $record) {
		/** @var $thread Tx_Dialog_Domain_Model_Thread */
		$thread = $this->threadRepository->findByUid($record['uid']);
		return $thread->getPosts()->current()->getSubject();
	}

	/**
	 * @param array $record
	 * @return DateTime
	 */
	public function extractDateTimeFromRecord(array $record) {
		/** @var $thread Tx_Dialog_Domain_Model_Thread */
		$thread = $this->threadRepository->findByUid($record['uid']);
		return $thread->getLastActivity();
	}

}