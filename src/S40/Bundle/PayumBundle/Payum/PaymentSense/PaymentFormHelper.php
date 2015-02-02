<?php

namespace S40\Bundle\PayumBundle\Payum\PaymentSense;

/*
 * Disclaimer: PaymentSense provides this code as an example of a working integration module.
 * Responsibility for the final implementation, functionality and testing of the module resides with the merchant/merchants website developer.
*/
class TransactionResult
{
    private $m_nStatusCode;
    private $m_szMessage;
    private $m_nPreviousStatusCode;
    private $m_szPreviousMessage;
    private $m_szCrossReference;
    private $m_szCardType;
    private $m_szCardClass;
    private $m_szCardIssuer;
    private $m_szCardIssuerCountryCode;
    private $m_nAmount;
    private $m_nCurrencyCode;
    private $m_szOrderID;
    private $m_szTransactionType;
    private $m_szTransactionDateTime;
    private $m_szOrderDescription;
    private $m_szCustomerName;
    private $m_szAddress1;
    private $m_szAddress2;
    private $m_szAddress3;
    private $m_szAddress4;
    private $m_szCity;
    private $m_szState;
    private $m_szPostCode;
    private $m_nCountryCode;
    private $m_szEmailAddress;
    private $m_szPhoneNumber;

    public function getStatusCode()
    {
        return $this->m_nStatusCode;
    }
    public function setStatusCode($nStatusCode)
    {
        $this->m_nStatusCode = $nStatusCode;
    }
    public function getMessage()
    {
        return $this->m_szMessage;
    }
    public function setMessage($szMessage)
    {
        $this->m_szMessage = $szMessage;
    }
    public function getPreviousStatusCode()
    {
        return $this->m_nPreviousStatusCode;
    }
    public function setPreviousStatusCode($nPreviousStatusCode)
    {
        $this->m_nPreviousStatusCode = $nPreviousStatusCode;
    }
    public function getPreviousMessage()
    {
        return $this->m_szPreviousMessage;
    }
    public function setPreviousMessage($szPreviousMessage)
    {
        $this->m_szPreviousMessage = $szPreviousMessage;
    }
    public function getCrossReference()
    {
        return $this->m_szCrossReference;
    }
    public function setCrossReference($szCrossReference)
    {
        $this->m_szCrossReference = $szCrossReference;
    }
public function getCardType()
    {
        return $this->m_szCardType;
    }
public function setCardType($szCardType)
    {
        $this->m_szCardType = $szCardType;
    }
public function getCardClass()
    {
        return $this->m_szCardClass;
    }
public function setCardClass($szCardClass)
    {
        $this->m_szCardClass = $szCardClass;
    }
public function getCardIssuer()
    {
        return $this->m_szCardIssuer;
    }
public function setCardIssuer($szCardIssuer)
    {
        $this->m_szCardIssuer = $szCardIssuer;
    }
public function getCardIssuerCountryCode()
    {
        return $this->m_szCardIssuerCountryCode;
    }
public function setCardIssuerCountryCode($szCardIssuerCountryCode)
    {
        $this->m_szCardIssuerCountryCode = $szCardIssuerCountryCode;
    }
    public function getAmount()
    {
        return $this->m_nAmount;
    }
    public function setAmount($nAmount)
    {
        $this->m_nAmount = $nAmount;
    }
    public function getCurrencyCode()
    {
        return $this->m_nCurrencyCode;
    }
    public function setCurrencyCode($nCurrencyCode)
    {
        $this->m_nCurrencyCode = $nCurrencyCode;
    }
    public function getOrderID()
    {
        return $this->m_szOrderID;
    }
    public function setOrderID($szOrderID)
    {
        $this->m_szOrderID = $szOrderID;
    }
    public function getTransactionType()
    {
        return $this->m_szTransactionType;
    }
    public function setTransactionType($szTransactionType)
    {
        $this->m_szTransactionType = $szTransactionType;
    }
    public function getTransactionDateTime()
    {
        return $this->m_szTransactionDateTime;
    }
    public function setTransactionDateTime($szTransactionDateTime)
    {
        $this->m_szTransactionDateTime = $szTransactionDateTime;
    }
    public function getOrderDescription()
    {
        return $this->m_szOrderDescription;
    }
    public function setOrderDescription($szOrderDescription)
    {
        $this->m_szOrderDescription = $szOrderDescription;
    }
    public function getCustomerName()
    {
        return $this->m_szCustomerName;
    }
    public function setCustomerName($szCustomerName)
    {
        $this->m_szCustomerName = $szCustomerName;
    }
    public function getAddress1()
    {
        return $this->m_szAddress1;
    }
    public function setAddress1($szAddress1)
    {
        $this->m_szAddress1 = $szAddress1;
    }
    public function getAddress2()
    {
        return $this->m_szAddress2;
    }
    public function setAddress2($szAddress2)
    {
        $this->m_szAddress2 = $szAddress2;
    }
    public function getAddress3()
    {
        return $this->m_szAddress3;
    }
    public function setAddress3($szAddress3)
    {
        $this->m_szAddress3 = $szAddress3;
    }
    public function getAddress4()
    {
        return $this->m_szAddress4;
    }
    public function setAddress4($szAddress4)
    {
        $this->m_szAddress4 = $szAddress4;
    }
    public function getCity()
    {
        return $this->m_szCity;
    }
    public function setCity($szCity)
    {
        $this->m_szCity = $szCity;
    }
    public function getState()
    {
        return $this->m_szState;
    }
    public function setState($szState)
    {
        $this->m_szState = $szState;
    }
    public function getPostCode()
    {
        return $this->m_szPostCode;
    }
    public function setPostCode($szPostCode)
    {
        $this->m_szPostCode = $szPostCode;
    }
    public function getCountryCode()
    {
        return $this->m_nCountryCode;
    }
    public function setCountryCode($nCountryCode)
    {
        $this->m_nCountryCode = $nCountryCode;
    }
    public function getEmailAddress()
    {
        return $this->m_szEmailAddress;
    }
    public function setEmailAddress($szEmailAddress)
    {
        $this->m_szEmailAddress = $szEmailAddress;
    }
    public function getPhoneNumber()
    {
        return $this->m_szPhoneNumber;
    }
    public function setPhoneNumber($szPhoneNumber)
    {
        $this->m_szPhoneNumber = $szPhoneNumber;
    }

}

class PaymentFormHelper
{
    public static function boolToString($boBool)
    {
        $szReturnValue = 'false';

        if ($boBool) {
            $szReturnValue = 'true';
        }

            return ($szReturnValue);
    }
    public static function stringToBool($szString)
    {
        $boReturnValue = false;

        if (strToUpper($szString) == 'TRUE') {
            $boReturnValue = true;
        }

            return ($boReturnValue);
    }
    public static function getSiteSecureBaseURL()
    {
        $szReturnString = '';
        $szPortString = '';
        $szProtocolString = '';

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $szProtocolString = 'https://';
            if ($_SERVER['SERVER_PORT'] != 443) {
                $szPortString = ':'.$_SERVER['SERVER_PORT'];
            }
        } else {
            $szProtocolString = 'http://';
            if ($_SERVER['SERVER_PORT'] != 80) {
                $szPortString = ':'.$_SERVER['SERVER_PORT'];
            }
        }

        $szReturnString = $szProtocolString.$_SERVER['SERVER_NAME'].$szPortString.$_SERVER['SCRIPT_NAME'];

        $boFinished = false;
        $LoopIndex = strlen($szReturnString) - 1;

        while ($boFinished == false &&
               $LoopIndex >= 0)
        {
            if ($szReturnString[$LoopIndex] == '/') {
                $boFinished = true;
                $szReturnString = substr($szReturnString, 0, $LoopIndex + 1);
            }
            $LoopIndex--;
        }

        return ($szReturnString);
    }

    public static function getTransactionReferenceFromQueryString($aQueryStringVariables, &$szCrossReference, &$szOrderID, &$szHashDigest, &$szOutputMessage)
    {
        $trTransactionResult = null;
        $szHashDigest = '';
        $szOutputMessage = '';
        $boErrorOccurred = false;

        try {
            // hash digest
            if (isset($aQueryStringVariables['HashDigest'])) {
                $szHashDigest = $aQueryStringVariables['HashDigest'];
            }

            // cross reference of transaction
            if (!isset($aQueryStringVariables['CrossReference'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CrossReference] not received');
                $boErrorOccurred = true;
            } else {
                $szCrossReference = $aQueryStringVariables['CrossReference'];
            }
            // Card Type of transaction
            if (!isset($aQueryStringVariables['CardType'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, "Expected variable [CardType] not received");
                $boErrorOccurred = false;
            } else {
                $szCardType = $aQueryStringVariables['CardType'];
            }
            // Card Class of transaction
            if (!isset($aQueryStringVariables['CardClass'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, "Expected variable [CardClass] not received");
                $boErrorOccurred = false;
            } else {
                $szCardClass = $aQueryStringVariables['CardClass'];
            }
        // Card Issuer of transaction
            if (!isset($aQueryStringVariables['CardIssuer'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, "Expected variable [CardIssuer] not received");
                $boErrorOccurred = false;
            } else {
                $szCardIssuer = $aQueryStringVariables['CardIssuer'];
            }
            // Card Issuer Country Code of transaction
            if (!isset($aQueryStringVariables['CardIssuerCountryCode'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, "Expected variable [CardIssuerCountryCode] not received");
                $boErrorOccurred = false;
            } else {
                $szCardIssuer = $aQueryStringVariables['CardIssuerCountryCode'];
            }
            // order ID (same as value passed into payment form - echoed back out by payment form)
            if (!isset($aQueryStringVariables['OrderID'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, "Expected variable [OrderID] not received");
                $boErrorOccurred = false;
            } else {
                $szOrderID = $aQueryStringVariables['OrderID'];
            }
        } catch (Exception $e) {
            $boErrorOccurred = true;
            $szOutputMessage = $e->getMessage();
        }

        return (!$boErrorOccurred);
    }
    public static function getTransactionResultFromPostVariables($aFormVariables, &$trTransactionResult, &$szHashDigest, &$szOutputMessage)
    {
        $trTransactionResult = null;
        $szHashDigest = '';
        $szOutputMessage = '';
        $boErrorOccurred = false;

        try {
            // hash digest
            if (isset($aFormVariables['HashDigest'])) {
                $szHashDigest = $aFormVariables['HashDigest'];
            }

            // transaction status code
            if (!isset($aFormVariables['StatusCode'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [StatusCode] not received');
                $boErrorOccurred = true;
            } else {
                if ($aFormVariables['StatusCode'] == '') {
                    $nStatusCode = null;
                } else {
                    $nStatusCode = intval($aFormVariables['StatusCode']);
                }
            }
            // transaction message
            if (!isset($aFormVariables['Message'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [Message] not received');
                $boErrorOccurred = true;
            } else {
                $szMessage = $aFormVariables['Message'];
            }
            // status code of original transaction if this transaction was deemed a duplicate
            if (!isset($aFormVariables['PreviousStatusCode'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [PreviousStatusCode] not received');
                $boErrorOccurred = true;
            } else {
                if ($aFormVariables['PreviousStatusCode'] == '') {
                    $nPreviousStatusCode = null;
                } else {
                    $nPreviousStatusCode = intval($aFormVariables['PreviousStatusCode']);
                }
            }
            // status code of original transaction if this transaction was deemed a duplicate
            if (!isset($aFormVariables['PreviousMessage'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [PreviousMessage] not received');
                $boErrorOccurred = true;
            } else {
                $szPreviousMessage = $aFormVariables['PreviousMessage'];
            }
            // cross reference of transaction
            if (!isset($aFormVariables['CrossReference'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CrossReference] not received');
                $boErrorOccurred = true;
            } else {
                $szCrossReference = $aFormVariables['CrossReference'];
            }
            // Card Type of transaction
            if (!isset($aFormVariables['CardType'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CardType] not received');
                $boErrorOccurred = false;
                $szCardType = '';
            } else {
                $szCardType = $aFormVariables['CardType'];
            }
            // Card Class of transaction
            if (!isset($aFormVariables['CardClass'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CardClass] not received');
                $boErrorOccurred = false;
                $szCardClass='';
            } else {
                $szCardClass = $aFormVariables['CardClass'];
            }
            // Card Issuer of transaction
            if (!isset($aFormVariables['CardIssuer'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CardIssuer] not received');
                $boErrorOccurred = false;
                $szCardIssuer = '';
            } else {
                $szCardIssuer = $aFormVariables['CardIssuer'];
            }
            // Card Issuer Country Code of transaction
            if (!isset($aFormVariables['CardIssuerCountryCode'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CardIssuerCountryCode] not received');
                $boErrorOccurred = false;
                $szCardIssuerCountryCode = '';
            } else {
                $szCardIssuerCountryCode = $aFormVariables['CardIssuerCountryCode'];
            }
            // amount (same as value passed into payment form - echoed back out by payment form)
            if (!isset($aFormVariables['Amount'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [Amount] not received');
                $boErrorOccurred = true;
            } else {
                if ($aFormVariables['Amount'] == null) {
                    $nAmount = null;
                } else {
                    $nAmount = intval($aFormVariables['Amount']);
                }
            }
            // currency code (same as value passed into payment form - echoed back out by payment form)
            if (!isset($aFormVariables['CurrencyCode'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CurrencyCode] not received');
                $boErrorOccurred = true;
            } else {
                if ($aFormVariables['CurrencyCode'] == null) {
                    $nCurrencyCode = null;
                } else {
                    $nCurrencyCode = intval($aFormVariables['CurrencyCode']);
                }
            }
            // order ID (same as value passed into payment form - echoed back out by payment form)
            if (!isset($aFormVariables['OrderID'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [OrderID] not received');
                $boErrorOccurred = true;
            } else {
                $szOrderID = $aFormVariables['OrderID'];
            }
            // transaction type (same as value passed into payment form - echoed back out by payment form)
            if (!isset($aFormVariables['TransactionType'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [TransactionType] not received');
                $boErrorOccurred = true;
            } else {
                $szTransactionType = $aFormVariables['TransactionType'];
            }
            // transaction date/time (same as value passed into payment form - echoed back out by payment form)
            if (!isset($aFormVariables['TransactionDateTime'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [TransactionDateTime] not received');
                $boErrorOccurred = true;
            } else {
                $szTransactionDateTime = $aFormVariables['TransactionDateTime'];
            }
            // order description (same as value passed into payment form - echoed back out by payment form)
            if (!isset($aFormVariables['OrderDescription'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [OrderDescription] not received');
                $boErrorOccurred = true;
            } else {
                $szOrderDescription = $aFormVariables['OrderDescription'];
            }
            // customer name (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['CustomerName'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CustomerName] not received');
                $boErrorOccurred = true;
            } else {
                $szCustomerName = $aFormVariables['CustomerName'];
            }
            // address1 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['Address1'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [Address1] not received');
                $boErrorOccurred = true;
            } else {
                $szAddress1 = $aFormVariables['Address1'];
            }
            // address2 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['Address2'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [Address2] not received');
                $boErrorOccurred = true;
            } else {
                $szAddress2 = $aFormVariables['Address2'];
            }
            // address3 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['Address3'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [Address3] not received');
                $boErrorOccurred = true;
            } else {
                $szAddress3 = $aFormVariables['Address3'];
            }
            // address4 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['Address4'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [Address4] not received');
                $boErrorOccurred = true;
            } else {
                $szAddress4 = $aFormVariables['Address4'];
            }
            // city (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables["City"])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [City] not received');
                $boErrorOccurred = true;
            } else {
                $szCity = $aFormVariables['City'];
            }
            // state (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['State'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [State] not received');
                $boErrorOccurred = true;
            } else {
                $szState = $aFormVariables['State'];
            }
            // post code (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['PostCode'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [PostCode] not received');
                $boErrorOccurred = true;
            } else {
                $szPostCode = $aFormVariables['PostCode'];
            }
            // country code (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['CountryCode'])) {
                $szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [CountryCode] not received');
                $boErrorOccurred = true;
            } else {
                if ($aFormVariables['CountryCode'] == '') {
                    $nCountryCode = null;
                } else {
                    $nCountryCode = intval($aFormVariables['CountryCode']);
                }
            }
        // email address (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['EmailAddress'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [EmailAddress] not received');
                $boErrorOccurred = false;
                $szEmailAddress = '';
            } else {
                $szEmailAddress = $aFormVariables['EmailAddress'];
            }
        // phone number (not necessarily the same as value passed into payment form - as the customer can change it on the form)
            if (!isset($aFormVariables['PhoneNumber'])) {
                //$szOutputMessage = PaymentFormHelper::addStringToStringList($szOutputMessage, 'Expected variable [PhoneNumber] not received');
                $boErrorOccurred = false;
                $szPhoneNumber = '';
            } else {
                $szPhoneNumber = $aFormVariables['PhoneNumber'];
            }

            if (!$boErrorOccurred) {
                $trTransactionResult = new TransactionResult();
                $trTransactionResult->setStatusCode($nStatusCode); // transaction status code
                $trTransactionResult->setMessage($szMessage); // transaction message
                $trTransactionResult->setPreviousStatusCode($nPreviousStatusCode); // status code of original transaction if duplicate transaction
                $trTransactionResult->setPreviousMessage($szPreviousMessage); // status code of original transaction if duplicate transaction
                $trTransactionResult->setCrossReference($szCrossReference);    // cross reference of transaction
                $trTransactionResult->setCardType($szCardType); // CardType
                $trTransactionResult->setCardClass($szCardClass); // CardClass
                $trTransactionResult->setCardIssuer($szCardIssuer); // CardIssuer
                $trTransactionResult->setCardIssuerCountryCode($szCardIssuerCountryCode); // CardIssuerCountryCode
                $trTransactionResult->setAmount($nAmount); // amount echoed back
                $trTransactionResult->setCurrencyCode($nCurrencyCode); // currency code echoed back
                $trTransactionResult->setOrderID($szOrderID); // order ID echoed back
                $trTransactionResult->setTransactionType($szTransactionType); // transaction type echoed back
                $trTransactionResult->setTransactionDateTime($szTransactionDateTime); // transaction date/time echoed back
                $trTransactionResult->setOrderDescription($szOrderDescription); // order description echoed back
                // the customer details that were actually
                // processed (might be different
                // from those passed to the payment form)
                $trTransactionResult->setCustomerName($szCustomerName);
                $trTransactionResult->setAddress1($szAddress1);
                $trTransactionResult->setAddress2($szAddress2);
                $trTransactionResult->setAddress3($szAddress3);
                $trTransactionResult->setAddress4($szAddress4);
                $trTransactionResult->setCity($szCity);
                $trTransactionResult->setState($szState);
                $trTransactionResult->setPostCode($szPostCode);
                $trTransactionResult->setCountryCode($nCountryCode);
                $trTransactionResult->setEmailAddress($szEmailAddress);
                $trTransactionResult->setPhoneNumber($szPhoneNumber);

            }
        } catch (Exception $e) {
            $boErrorOccurred = true;
            $szOutputMessage = $e->getMessage();
        }

        return (!$boErrorOccurred);
    }
    public static function addStringToStringList($szExistingStringList, $szStringToAdd)
    {
        $szReturnString = '';
        $szCommaString = '';

        if (strlen($szStringToAdd) == 0) {
            $szReturnString = $szExistingStringList;
        } else {
            if (strlen($szExistingStringList) != 0) {
                $szCommaString = ', ';
            }
            $szReturnString = $szExistingStringList.$szCommaString.$szStringToAdd;
        }

        return ($szReturnString);
    }
    public static function calculateHashDigest($szInputString, $szPreSharedKey, $szHashMethod)
    {
        switch ($szHashMethod) {
            case 'MD5':
                $hashDigest = md5($szInputString);
                break;
            case 'SHA1':
                $hashDigest = sha1($szInputString);
                break;
            case 'HMACMD5':
                $hashDigest = hash_hmac('md5', $szInputString, $szPreSharedKey);
                break;
            case 'HMACSHA1':
                $hashDigest = hash_hmac('sha1', $szInputString, $szPreSharedKey);
                break;
        }

        return ($hashDigest);
    }
    public static function generateStringToHash($szMerchantID,
                                                $szPassword,
                                                $szAmount,
                                                $szCurrencyCode,
                                                $szEchoCardType,
                                                $szOrderID,
                                                $szTransactionType,
                                                $szTransactionDateTime,
                                                $szCallbackURL,
                                                $szOrderDescription,
                                                $szCustomerName,
                                                $szAddress1,
                                                $szAddress2,
                                                $szAddress3,
                                                $szAddress4,
                                                $szCity,
                                                $szState,
                                                $szPostCode,
                                                $szCountryCode,
                                                $szEmailAddress,
                                                $szPhoneNumber,
                                                $szEmailAddressEditable,
                                                $szPhoneNumberEditable,
                                                $szCV2Mandatory,
                                                $szAddress1Mandatory,
                                                $szCityMandatory,
                                                $szPostCodeMandatory,
                                                $szStateMandatory,
                                                $szCountryMandatory,
                                                $szResultDeliveryMethod,
                                                $szServerResultURL,
                                                $szPaymentFormDisplaysResult,
                                                 $szPreSharedKey,
                                                 $szHashMethod)
    {
        $szReturnString = '';

        switch ($szHashMethod) {
            case 'MD5':
                $boIncludePreSharedKeyInString = true;
                break;
            case 'SHA1':
                $boIncludePreSharedKeyInString = true;
                break;
            case 'HMACMD5':
                $boIncludePreSharedKeyInString = false;
                break;
            case 'HMACSHA1':
                $boIncludePreSharedKeyInString = false;
                break;
        }

        if ($boIncludePreSharedKeyInString) {
            $szReturnString = 'PreSharedKey='.$szPreSharedKey.'&';
        }

        $szReturnString = $szReturnString.'MerchantID='.$szMerchantID.
                                          '&Password='.$szPassword.
                                          '&Amount='.$szAmount.
                                          '&CurrencyCode='.$szCurrencyCode.
                                          '&EchoCardType='.$szEchoCardType.
                                          '&OrderID='.$szOrderID.
                                          '&TransactionType='.$szTransactionType.
                                          '&TransactionDateTime='.$szTransactionDateTime.
                                          '&CallbackURL='.$szCallbackURL.
                                          '&OrderDescription='.$szOrderDescription.
                                          '&CustomerName='.$szCustomerName.
                                          '&Address1='.$szAddress1.
                                          '&Address2='.$szAddress2.
                                          '&Address3='.$szAddress3.
                                          '&Address4='.$szAddress4.
                                          '&City='.$szCity.
                                          '&State='.$szState.
                                          '&PostCode='.$szPostCode.
                                          '&CountryCode='.$szCountryCode.
                                          '&EmailAddress='.$szEmailAddress.
                                          '&PhoneNumber='.$szPhoneNumber.
                                          '&EmailAddressEditable='.$szEmailAddressEditable.
                                          '&PhoneNumberEditable='.$szPhoneNumberEditable.
                                          '&CV2Mandatory='.$szCV2Mandatory.
                                          '&Address1Mandatory='.$szAddress1Mandatory.
                                          '&CityMandatory='.$szCityMandatory.
                                          '&PostCodeMandatory='.$szPostCodeMandatory.
                                          '&StateMandatory='.$szStateMandatory.
                                          '&CountryMandatory='.$szCountryMandatory.
                                          '&ResultDeliveryMethod='.$szResultDeliveryMethod.
                                          '&ServerResultURL='.$szServerResultURL.
                                          '&PaymentFormDisplaysResult='.$szPaymentFormDisplaysResult.
                                          '&ServerResultURLCookieVariables='.
                                          '&ServerResultURLFormVariables='.
                                          '&ServerResultURLQueryStringVariables=';

        return ($szReturnString);
    }
    public static function generateStringToHash2($szMerchantID,
                                                 $szPassword,
                                                 $trTransactionResult,
                                                  $szPreSharedKey,
                                                  $szHashMethod)
    {
        $szReturnString = '';

        switch ($szHashMethod) {
            case 'MD5':
                $boIncludePreSharedKeyInString = true;
                break;
            case 'SHA1':
                $boIncludePreSharedKeyInString = true;
                break;
            case 'HMACMD5':
                $boIncludePreSharedKeyInString = false;
                break;
            case 'HMACSHA1':
                $boIncludePreSharedKeyInString = false;
                break;
        }

        if ($boIncludePreSharedKeyInString) {
            $szReturnString = 'PreSharedKey='.$szPreSharedKey.'&';
        }

        $szReturnString = $szReturnString.'MerchantID='.$szMerchantID.
                                          '&Password='.$szPassword.
                                          '&StatusCode='.$trTransactionResult->getStatusCode().
                                          '&Message='.$trTransactionResult->getMessage().
                                          '&PreviousStatusCode='.$trTransactionResult->getPreviousStatusCode().
                                          '&PreviousMessage='.$trTransactionResult->getPreviousMessage().
                                          '&CrossReference='.$trTransactionResult->getCrossReference().
                                          '&CardType='.$trTransactionResult->getCardType().
                                          '&CardClass='.$trTransactionResult->getCardClass().
                                          '&CardIssuer='.$trTransactionResult->getCardIssuer().
                                          '&CardIssuerCountryCode='.$trTransactionResult->getCardIssuerCountryCode().
                                          '&Amount='.$trTransactionResult->getAmount().
                                          '&CurrencyCode='.$trTransactionResult->getCurrencyCode().
                                          '&OrderID='.$trTransactionResult->getOrderID().
                                          '&TransactionType='.$trTransactionResult->getTransactionType().
                                          '&TransactionDateTime='.$trTransactionResult->getTransactionDateTime().
                                          '&OrderDescription='.$trTransactionResult->getOrderDescription().
                                          '&CustomerName='.$trTransactionResult->getCustomerName().
                                          '&Address1='.$trTransactionResult->getAddress1().
                                          '&Address2='.$trTransactionResult->getAddress2().
                                          '&Address3='.$trTransactionResult->getAddress3().
                                          '&Address4='.$trTransactionResult->getAddress4().
                                          '&City='.$trTransactionResult->getCity().
                                          '&State='.$trTransactionResult->getState().
                                          '&PostCode='.$trTransactionResult->getPostCode().
                                          '&CountryCode='.$trTransactionResult->getCountryCode().
                                          '&EmailAddress='.$trTransactionResult->getEmailAddress().
                                          '&PhoneNumber='.$trTransactionResult->getPhoneNumber();

        return ($szReturnString);
    }
    public static function generateStringToHash3($szMerchantID,
                                                 $szPassword,
                                                 $szCrossReference,
                                                 $szOrderID,
                                                  $szPreSharedKey,
                                                  $szHashMethod)
    {
        $szReturnString = '';

        switch ($szHashMethod) {
            case 'MD5':
                $boIncludePreSharedKeyInString = true;
                break;
            case 'SHA1':
                $boIncludePreSharedKeyInString = true;
                break;
            case 'HMACMD5':
                $boIncludePreSharedKeyInString = false;
                break;
            case 'HMACSHA1':
                $boIncludePreSharedKeyInString = false;
                break;
        }

        if ($boIncludePreSharedKeyInString) {
            $szReturnString = 'PreSharedKey='.$szPreSharedKey.'&';
        }

        $szReturnString = $szReturnString.'MerchantID='.$szMerchantID.
                                          '&Password='.$szPassword.
                                          '&CrossReference='.$szCrossReference.
                                          '&OrderID='.$szOrderID;

        return ($szReturnString);
    }
    public static function validateTransactionResult_POST($szMerchantID,
                                                          $szPassword,
                                                          $szPreSharedKey,
                                                          $szHashMethod,
                                                          $aPostVariables,
                                                          &$trTransactionResult,
                                                          &$szValidateErrorMessage)
    {
        $boErrorOccurred = false;

        $szValidateErrorMessage = '';
        $trTransactionResult = null;

        // read the transaction result variables from the post variable list
        if (!PaymentFormHelper::getTransactionResultFromPostVariables($aPostVariables, $trTransactionResult, $szHashDigest, $szOutputMessage)) {
            $boErrorOccurred = true;
            $szValidateErrorMessage = $szOutputMessage;
        } else {
            // now need to validate the hash digest
            $szStringToHash = PaymentFormHelper::generateStringToHash2($szMerchantID, $szPassword, $trTransactionResult, $szPreSharedKey, $szHashMethod);
            $szCalculatedHashDigest = PaymentFormHelper::calculateHashDigest($szStringToHash, $szPreSharedKey, $szHashMethod);

            // does the calculated hash match the one that was passed?
            if (strToUpper($szHashDigest) != strToUpper($szCalculatedHashDigest)) {
                $boErrorOccurred = true;
                $szValidateErrorMessage = 'Hash digests do not match - possible variable tampering';
            } else {
                $boErrorOccurred = false;
            }
        }

        return (!$boErrorOccurred);
    }
    public static function validateTransactionResult_SERVER($szMerchantID,
                                                            $szPassword,
                                                            $szPreSharedKey,
                                                            $szHashMethod,
                                                            $aQueryStringVariables,
                                                            &$trTransactionResult,
                                                            &$szValidateErrorMessage)
    {
        $boErrorOccurred = false;

        $szValidateErrorMessage = '';
        $trTransactionResult = null;

        // read the transaction reference variables from the query string variable list
        if (!PaymentFormHelper::getTransactionReferenceFromQueryString($aQueryStringVariables, $szCrossReference, $szOrderID, $szHashDigest, $szOutputMessage)) {
            $boErrorOccurred = true;
            $szValidateErrorMessage = $szOutputMessage;
        } else {
            // now need to validate the hash digest
            $szStringToHash = PaymentFormHelper::generateStringToHash3($szMerchantID, $szPassword, $szCrossReference, $szOrderID, $szPreSharedKey, $szHashMethod);
            $szCalculatedHashDigest = PaymentFormHelper::calculateHashDigest($szStringToHash, $szPreSharedKey, $szHashMethod);

            // does the calculated hash match the one that was passed?
            if (strToUpper($szHashDigest) != strToUpper($szCalculatedHashDigest)) {
                $boErrorOccurred = true;
                $szValidateErrorMessage = 'Hash digests do not match - possible variable tampering';
            } else {
                // use the cross reference and/or the order ID to pull the
                // transaction results out of storage
                if (!PaymentFormHelper::getTransactionResultFromStorage($szCrossReference,
                                                                        $szOrderID,
                                                                        $trTransactionResult,
                                                                        $szOutputMessage))
                {
                    $szValidateErrorMessage = $szOutputMessage;
                    $boErrorOccurred = true;
                } else {
                    $boErrorOccurred = false;
                }
            }
        }

        return (!$boErrorOccurred);
    }
    public static function validateTransactionResult_SERVER_PULL($szMerchantID,
                                                                 $szPassword,
                                                                 $szPreSharedKey,
                                                                 $szHashMethod,
                                                                 $aQueryStringVariables,
                                                                 $szPaymentFormResultHandlerURL,
                                                                    &$trTransactionResult,
                                                                 &$szValidateErrorMessage)
    {
        $boErrorOccurred = false;

        $szValidateErrorMessage = '';
        $trTransactionResult = null;

        // read the transaction reference variables from the query string variable list
        if (!PaymentFormHelper::getTransactionReferenceFromQueryString($aQueryStringVariables, $szCrossReference, $szOrderID, $szHashDigest, $szOutputMessage)) {
            $boErrorOccurred = true;
            $szValidateErrorMessage = $szOutputMessage;
        } else {
            // now need to validate the hash digest
            $szStringToHash = PaymentFormHelper::generateStringToHash3($szMerchantID, $szPassword, $szCrossReference, $szOrderID, $szPreSharedKey, $szHashMethod);
            $szCalculatedHashDigest = PaymentFormHelper::calculateHashDigest($szStringToHash, $szPreSharedKey, $szHashMethod);

            // does the calculated hash match the one that was passed?
            if (strToUpper($szHashDigest) != strToUpper($szCalculatedHashDigest)) {
                $boErrorOccurred = true;
                $szValidateErrorMessage = 'Hash digests do not match - possible variable tampering';
            } else {
                // use the cross reference and/or the order ID to pull the
                // transaction results out of storage
                if (!PaymentFormHelper::getTransactionResultFromPaymentFormHandler($szPaymentFormResultHandlerURL,
                                                                                   $szMerchantID,
                                                                                   $szPassword,
                                                                                   $szCrossReference,
                                                                                   $trTransactionResult,
                                                                                   $szOutputMessage))
                {
                    $szValidateErrorMessage = 'Error querying transaction result ['.$szCrossReference.'] from ['.$szPaymentFormResultHandlerURL.']: '.$szOutputMessage;
                    $boErrorOccurred = true;
                } else {
                    $boErrorOccurred = false;
                }
            }
        }

        return (!$boErrorOccurred);
    }
    public static function parseNameValueStringIntoArray($szNameValueString, $boURLDecodeValues)
    {
        // break the reponse into an array
        // first break the variables up using the '&' delimter
        $aPostVariables = explode('&', $szNameValueString);

        $aParsedVariables = array();

        foreach ($aPostVariables as $szVariable) {
            // for each variable, split is again on the '=' delimiter
            // to give name/value pairs
            $aSingleVariable = explode('=', $szVariable);
            $szName = $aSingleVariable[0];
            if (!$boURLDecodeValues) {
                $szValue = $aSingleVariable[1];
            } else {
                $szValue = urldecode($aSingleVariable[1]);
            }

            $aParsedVariables[$szName] = $szValue;
        }

        return ($aParsedVariables);
    }
    public static function getTransactionResultFromPaymentFormHandler($szPaymentFormResultHandlerURL,
                                                                      $szMerchantID,
                                                                      $szPassword,
                                                                      $szCrossReference,
                                                                      &$trTransactionResult,
                                                                      &$szOutputMessage)
    {
        $boErrorOccurred = false;
        $szOutputMessage = '';
        $trTransactionResult = null;

        try {
            // use curl to post the cross reference to the
            // payment form to query its status
            $cCURL = curl_init();

            // build up the post string
            $szPostString = 'MerchantID='.urlencode($szMerchantID).'&Password='.urlencode($szPassword).'&CrossReference='.urlencode($szCrossReference);

            curl_setopt($cCURL, CURLOPT_URL, $szPaymentFormResultHandlerURL);
            curl_setopt($cCURL, CURLOPT_POST, true);
            curl_setopt($cCURL, CURLOPT_POSTFIELDS, $szPostString);
            curl_setopt($cCURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($cCURL, CURLOPT_RETURNTRANSFER, true);

            // read the response
            $szResponse = curl_exec($cCURL);
            $szErrorNo = curl_errno($cCURL);
            $ezErrorMsg = curl_error($cCURL);
            $szHeaderInfo = curl_getinfo($cCURL);

            curl_close($cCURL);

            if ($szResponse == '') {
                $boErrorOccurred = true;
                $szOutputMessage = 'Received empty response from payment form hander';
            } else {
                try {
                    // parse the response into an array
                    $aParsedPostVariables = PaymentFormHelper::parseNameValueStringIntoArray($szResponse, true);

                    if (!isset($aParsedPostVariables['StatusCode']) OR
                        intval($aParsedPostVariables['StatusCode']) != 0)
                    {
                        $boErrorOccurred = true;

                        // the message field is expected if the status code is non-zero
                        if (!isset($aParsedPostVariables['Message'])) {
                            $szOutputMessage = 'Received invalid response from payment form hander ['.$szResponse.']';
                        } else {
                            $szOutputMessage = $aParsedPostVariables['Message'];
                        }
                    } else {
                        // status code is 0, so    get the transaction result
                        if (!isset($aParsedPostVariables['TransactionResult'])) {
                            $boErrorOccurred = true;
                            $szOutputMessage = 'No transaction result in response from payment form hander ['.$szResponse.']';
                        } else {
                            // parse the URL decoded transaction result field into a name value array
                            $aTransactionResultArray = PaymentFormHelper::parseNameValueStringIntoArray(urldecode($aParsedPostVariables['TransactionResult']), false);

                            // parse this array into a transaction result object
                            if (!PaymentFormHelper::getTransactionResultFromPostVariables($aTransactionResultArray, $trTransactionResult, $szHashDigest, $szErrorMessage)) {
                                $boErrorOccurred = true;
                                $szOutputMessage = 'Error ['.$szErrorMessage.'] parsing transaction result ['.urldecode($aParsedPostVariables['TransactionResult']).'] in response from payment form hander ['.$szResponse.']';
                            } else {
                                $boErrorOccurred = false;
                            }
                        }
                    }
                } catch (Exception $e) {
                    $boErrorOccurred = true;
                    $szOutputMessage = 'Exception ['.$e->getMessage().'] when processing response from payment form handler ['.$szResponse.']';
                }
            }
        } catch (Exception $e) {
            $boErrorOccurred = true;
            $szOutputMessage = $e->getMessage();
        }

        return (!$boErrorOccurred);
    }

    // These functions that are run to deal with storing and retrieving the
    // transaction results. They will be specific to the merchant environment, so cannot
    // be generalised. The developer MUST implement these functions

    // This function needs to be able to retrieve the saved transaction resultt
    // so that the result can be displayed to the customer
    public static function getTransactionResultFromStorage($szCrossReference,
                                                           $szOrderID,
                                                           &$trTransactionResult,
                                                           &$szOutputMessage)
    {
        $boErrorOccurred = true;
        $szOutputMessage = 'Environment specific function getTransactionResultFromStorage() needs to be implemented by merchant developer';
        $trTransactionResult = null;

        return (!$boErrorOccurred);
    }

    // You should put your code that does any post transaction tasks
    // (e.g. updates the order object, sends the customer an email etc) in this function
    public static function reportTransactionResults($trTransactionResult,
                                                    &$szOutputMessage)
    {
        $boErrorOccurred = false;
        //$szOutputMessage = "Environment specific function reportTransactionResults() needs to be implemented by merchant developer";

        try {
            switch ($trTransactionResult->getStatusCode()) {
                // transaction authorised
                case 0:
                    break;
                // card referred (treat as decline)
                case 4:
                    break;
                // transaction declined
                case 5:
                    break;
                // duplicate transaction
                case 20:
                    // need to look at the previous status code to see if the
                    // transaction was successful
                    if ($trTransactionResult->getPreviousStatusCode() == 0) {
                        // transaction authorised
                    } else {
                        // transaction not authorised
                    }
                    break;
                // error occurred
                case 30:
                    break;
                default:
                    break;
            }

            // put code to update/store the order with the transaction result
        } catch (Exception $e) {
            $boErrorOccurred = true;
            $szOutputMessage = $e->getMessage();
        }

        return (!$boErrorOccurred);
    }
}
