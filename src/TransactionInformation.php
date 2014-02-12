<?php

namespace EasyPayPal;

/**
 * Class TransactionInformation
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class TransactionInformation {

  public $id;
  public $currency;
  public $businessPayPalAccount;
  public $payPalDestination   = 'https://www.paypal.com/cgi-bin/webscr';
  public $transactionType     = '_cart';
  public $hasIndividualItems  = 1;
  public $hasShipping         = 0;
  public $handlingPrice       = 0;
  public $ipnUrl              = null;
  public $customerSuccessUrl  = '';
  public $customerCancelUrl   = '';

  public $items;
  public $listeners;

  public function getPaymentForm() {
    $formHTML = '';

    $formHTML .= '<form action="' . $this->payPalDestination . '" method="post">';
    $formHTML .= '<input type="hidden" name="custom" value="' . $this->id . '">';
    $formHTML .= '<input type="hidden" name="cmd" value="' . $this->transactionType . '">';
    $formHTML .= '<input type="hidden" name="upload" value="' . intval($this->hasIndividualItems) . '">';
    $formHTML .= '<input type="hidden" name="business" value="' . $this->businessPayPalAccount . '">';
    $formHTML .= '<input type="hidden" name="currency_code" value="' . $this->currency . '">';
    $formHTML .= '<input type="hidden" name="no_shipping" value="' . intval($this->hasShipping) . '">';
    $formHTML .= '<input type="hidden" name="handling_cart" value="' . $this->handlingPrice . '">';
    $formHTML .= '<input type="hidden" name="notify_url" value="' . $this->ipnUrl . '">';
    $formHTML .= '<input type="hidden" name="return" value="' . $this->customerSuccessUrl . '">';
    $formHTML .= '<input type="hidden" name="cancel_return" value="' . $this->customerCancelUrl . '">';

    foreach($this->_getItemListInformation() as $inputName => $inputValue)
      $formHTML .= '<input type="hidden" name="' . $inputName . '" value="' . $inputValue . '">';

    $formHTML .= $this->_getItemListInformationTable();

    $formHTML .= '<button>' . Lang::getInterfaceString('checkout') . '</button>';
    $formHTML .= '</form>';

    return $formHTML;
  }

  private function _getItemListInformationTable() {
    $tableHTML = '';

    $tableHTML .= '<table>';
    $tableHTML  .= '<thead>';
    $tableHTML    .= '<tr>';
    $tableHTML      .= '<th>' . Lang::getInterfaceString('item_name'). '</th>';
    $tableHTML      .= '<th>' . Lang::getInterfaceString('item_price'). '</th>';
    $tableHTML      .= '<th>' . Lang::getInterfaceString('item_quantity'). '</th>';
    $tableHTML      .= '<th>' . Lang::getInterfaceString('item_price_total'). '</th>';
    $tableHTML    .= '</tr>';
    $tableHTML  .= '</thead>';

    $tableHTML  .= '<tbody>';

    foreach($this->items as $item) {
      $tableHTML .= '<tr>';
      $tableHTML  .= '<td>' . $item->name . '</td>';
      $tableHTML  .= '<td>' . number_format($item->price, 2) . ' ' . $this->currency . '</td>';
      $tableHTML  .= '<td>' . $item->quantity . '</td>';
      $tableHTML  .= '<td>' . number_format( $item->price * $item->quantity, 2) . ' ' . $this->currency . '</td>';
      $tableHTML .= '</tr>';
    }

    $tableHTML .= '</tbody>';

    $tableHTML .= '</table>';

    return $tableHTML;
  }

  private function _getItemListInformation() {
    $information = array();

    $currentItemIndex = 1;

    foreach($this->items as $item) {
      foreach($item->getInformationArray() as $key => $value)
        $information[$key . '_' . $currentItemIndex] = $value;

      $currentItemIndex++;
    }

    return $information;
  }

}