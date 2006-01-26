<?php
/*
  $Id: password.php 64 2005-03-12 16:36:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/

  class osC_Products_Reviews extends osC_Template {

/* Private variables */

    var $_module = 'reviews',
        $_group = 'products',
        $_page_title,
        $_page_contents = 'reviews.php',
        $_page_image = 'table_background_reviews_new.gif';

/* Class constructor */

    function osC_Products_Reviews() {
      global $osC_Services, $osC_Language, $breadcrumb, $osC_Product, $osC_Customer, $osC_NavigationHistory;

      if ($osC_Services->isStarted('reviews') === false) {
        tep_redirect(tep_href_link(FILENAME_DEFAULT));
      }

      $this->_page_title = $osC_Language->get('reviews_heading');

      if ($osC_Services->isStarted('breadcrumb')) {
        $breadcrumb->add($osC_Language->get('breadcrumb_reviews'), tep_href_link(FILENAME_PRODUCTS, $this->_module));
      }

      if (is_numeric($_GET[$this->_module])) {
        if (osC_Reviews::exists($_GET[$this->_module])) {
          $osC_Product = new osC_Product(osC_Reviews::getProductID($_GET[$this->_module]));

          $this->_page_title = $osC_Product->getTitle();
          $this->_page_contents = 'reviews_info.php';

          if ($osC_Services->isStarted('breadcrumb')) {
            $breadcrumb->add($osC_Product->getTitle(), tep_href_link(FILENAME_PRODUCTS, $this->_module . '=' . $_GET[$this->_module]));
          }
        } else {
          $this->_page_contents = 'reviews_not_found.php';
        }
      } elseif (osC_Reviews::exists() === false) {
        $this->_page_contents = 'reviews_not_found.php';
      } else {
        $counter = 0;
        foreach ($_GET as $key => $value) {
          $counter++;

          if ($counter < 2) {
            continue;
          }

          if (is_numeric($key) || ereg('[0-9]+[{[0-9]+}[0-9]+]*$', $key) || ereg('[a-zA-Z0-9 -_]*$', $key)) {
            if (osC_Product::checkEntry($key) === false) {
              $this->_page_contents = 'info_not_found.php';
            } elseif ($_GET[$this->_module] == 'new') {
              if ( ($osC_Customer->isLoggedOn() === false ) && (SERVICE_REVIEW_ENABLE_REVIEWS == 1) ) {
                $osC_NavigationHistory->setSnapshot();

                tep_redirect(tep_href_link(FILENAME_ACCOUNT, 'login', 'SSL'));
              }

              $osC_Product = new osC_Product($key);

              $this->_page_title = $osC_Product->getTitle();
              $this->_page_contents = 'reviews_new.php';
              $this->addJavascriptPhpFilename('templates/' . $this->getCode() . '/javascript/products/reviews_new.php');

              if ($osC_Services->isStarted('breadcrumb')) {
                $breadcrumb->add($osC_Product->getTitle(), tep_href_link(FILENAME_PRODUCTS, $this->_module . '&' . $osC_Product->getKeyword()));
                $breadcrumb->add($osC_Language->get('breadcrumb_reviews_new'), tep_href_link(FILENAME_PRODUCTS, $this->_module . '=new&' . $osC_Product->getKeyword()));
              }

              if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
                $this->_process($osC_Product->getID());
              }
            } elseif (osC_Reviews::exists($key, true)) {
              $osC_Product = new osC_Product($key);

              $this->_page_title = $osC_Product->getTitle();
              $this->_page_contents = 'product_reviews.php';

              if ($osC_Services->isStarted('breadcrumb')) {
                $breadcrumb->add($osC_Product->getTitle(), tep_href_link(FILENAME_PRODUCTS, $this->_module . '&' . $osC_Product->getKeyword()));
              }
            } else {
              $this->_page_contents = 'reviews_not_found.php';
            }
          }

          break;
        }
      }
    }

/* Private methods */

    function _process($id) {
      global $osC_Language, $messageStack, $osC_Customer;

      $data = array('products_id' => $id);

      if ($osC_Customer->isLoggedOn()) {
        $data['customer_id'] = $osC_Customer->getID();
        $data['customer_name'] = $osC_Customer->getName();
      } else {
        $data['customer_id'] = '0';
        $data['customer_name'] = $_POST['customer_name'];
      }

      if (strlen(trim($_POST['review'])) < REVIEW_TEXT_MIN_LENGTH) {
        $messageStack->add('reviews', sprintf($osC_Language->get('js_review_text'), REVIEW_TEXT_MIN_LENGTH));
      } else {
        $data['review'] = $_POST['review'];
      }

      if (($_POST['rating'] < 1) || ($_POST['rating'] > 5)) {
        $messageStack->add('reviews', $osC_Language->get('js_review_rating'));
      } else {
        $data['rating'] = $_POST['rating'];
      }

      if ($messageStack->size('reviews') < 1) {
        if ($osC_Reviews->is_moderated === true) {
          $data['status'] = '0';

          $messageStack->add_session('reviews', $osC_Language->get('success_review_moderation'), 'success');
        } else {
          $data['status'] = '1';

          $messageStack->add_session('reviews', $osC_Language->get('success_review_new'), 'success');
        }

        osC_Reviews::saveEntry($data);

        tep_redirect(tep_href_link(FILENAME_PRODUCTS, 'reviews&' . $id));
      }
    }
  }
?>