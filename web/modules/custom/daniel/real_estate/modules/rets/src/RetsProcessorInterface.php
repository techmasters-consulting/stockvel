<?php

namespace Drupal\real_estate_rets;

/**
 * Processor of rets data.
 */
interface RetsProcessorInterface {

  /**
   * Claims an item in the rets fetch queue for processing.
   *
   * @return bool|object
   *   On success we return an item object. If the queue is unable to claim an
   *   item it returns false.
   *
   * @see \Drupal\Core\Queue\QueueInterface::claimItem()
   */
  public function claimQueueItem();

  /**
   * Attempts to drain the queue of tasks for release history data to fetch.
   */
  public function fetchData();

  /**
   * Adds a task to the queue.
   *
   * @param array $query
   *   Associative array of information about the query to fetch data for.
   */
  public function createFetchTask(array $query);

  /**
   * Processes a task to fetch available rets data for a single query.
   *
   * @param array $query
   *   Associative array of information about the query to fetch data for.
   *
   * @return bool
   *   TRUE if we fetched passable XML, otherwise FALSE.
   */
  public function processFetchTask(array $query);

  /**
   * Retrieves the number of items in the rets fetch queue.
   *
   * @return int
   *   An integer estimate of the number of items in the queue.
   *
   * @see \Drupal\Core\Queue\QueueInterface::numberOfItems()
   */
  public function numberOfQueueItems();

  /**
   * Deletes a finished item from the rets fetch queue.
   *
   * @param object $item
   *   The item returned by \Drupal\Core\Queue\QueueInterface::claimItem().
   */
  public function deleteQueueItem(\stdClass $item);

}
