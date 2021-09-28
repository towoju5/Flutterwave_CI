<?php
/*
 * Copyright 2012 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// Require the base class.
require_once __DIR__ . "/../BaseExample.php";

/**
 * This example gets all custom channels in a host ad client.
 *
 * To get ad clients, see GetAllAdClientsForHost.php.
 * Tags: customchannels.list
 *
 * @author Sérgio Gomes <sgomes@google.com>
 * @author Silvano Luciani <silvano.luciani@gmail.com>
 */
class GetAllCustomChannelsForHost extends BaseExample {
  public function render() {
    $adClientId = HOST_AD_CLIENT_ID;
    $optParams['maxResults'] = MAX_PAGE_SIZE;
    $listClass = 'list';
    printListHeader($listClass);
    $pageToken = null;
    do {
      $optParams['pageToken'] = $pageToken;
      // Retrieve custom channels list, and display it.
      $result = $this->adSenseHostService->customchannels
          ->listCustomchannels($adClientId, $optParams);
      $customChannels = $result['items'];
      if (isset($customChannels)) {
        foreach ($customChannels as $customChannel) {
          $content = array();
          $mainFormat =
              'Custom channel with ID "%s", code "%s" and name "%s" found.';
          $content[] = sprintf($mainFormat, $customChannel['id'],
              $customChannel['code'], $customChannel['name']);
          printListElementForClients($content);
        }
        $pageToken = isset($result['nextPageToken']) ? $result['nextPageToken']
            : null;
      } else {
        printNoResultForList();
      }
    } while ($pageToken);
    printListFooter();
  }
}

