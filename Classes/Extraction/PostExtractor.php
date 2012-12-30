<?php
class Tx_Dialog_Extraction_PostExtractor extends Tx_Dialog_Extraction_AbstractExtractor implements Tx_Notify_Extraction_ExtractorInterface {

	/**
	 * @var Tx_Dialog_Domain_Repository_PostRepository
	 */
	protected $postRepository;

	/**
	 * @param Tx_Dialog_Domain_Repository_PostRepository $postRepository
	 * @return void
	 */
	public function injectPostRepository(Tx_Dialog_Domain_Repository_PostRepository $postRepository) {
		$this->postRepository = $postRepository;
	}

	/**
	 * @param array $record
	 * @return string
	 */
	public function extractContentFromRecord(array $record) {
		/** @var $post Tx_Dialog_Domain_Model_Post */
		$post = $this->postRepository->findByUid($record['uid']);
		return $post->getContent();
	}

	/**
	 * @param array $record
	 * @return string
	 */
	public function extractTitleFromRecord(array $record) {
		/** @var $post Tx_Dialog_Domain_Model_Post */
		$post = $this->postRepository->findByUid($record['uid']);
		return $post->getSubject();
	}

	/**
	 * @param array $record
	 * @return DateTime
	 */
	public function extractDateTimeFromRecord(array $record) {
		/** @var $post Tx_Dialog_Domain_Model_Post */
		$post = $this->postRepository->findByUid($record['uid']);
		return $post->getCrdate();
	}

}