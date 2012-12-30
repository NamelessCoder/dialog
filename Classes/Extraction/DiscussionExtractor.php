<?php
class Tx_Dialog_Extraction_DiscussionExtractor extends Tx_Dialog_Extraction_AbstractExtractor implements Tx_Notify_Extraction_ExtractorInterface {

	/**
	 * @var Tx_Dialog_Domain_Repository_DiscussionRepository
	 */
	protected $discussionRepository;

	/**
	 * @param Tx_Dialog_Domain_Repository_DiscussionRepository $discussionRepository
	 * @return void
	 */
	public function injectDiscussionRepository(Tx_Dialog_Domain_Repository_DiscussionRepository $discussionRepository) {
		$this->discussionRepository = $discussionRepository;
	}

	/**
	 * @param array $record
	 * @return string
	 */
	public function extractContentFromRecord(array $record) {
		/** @var $discussion Tx_Dialog_Domain_Model_Discussion */
		$discussion = $this->discussionRepository->findByUid($record['uid']);
		return $discussion->getDescription();
	}

	/**
	 * @param array $record
	 * @return string
	 */
	public function extractTitleFromRecord(array $record) {
		/** @var $discussion Tx_Dialog_Domain_Model_Discussion */
		$discussion = $this->discussionRepository->findByUid($record['uid']);
		return $discussion->getTitle();
	}

	/**
	 * @param array $record
	 * @return DateTime
	 */
	public function extractDateTimeFromRecord(array $record) {
		/** @var $discussion Tx_Dialog_Domain_Model_Discussion */
		$discussion = $this->discussionRepository->findByUid($record['uid']);
		return $discussion->getLastActivity();
	}

}