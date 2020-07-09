<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* SecureScore File
* PHP version 7
*
* @category  Library
* @package   Microsoft.Graph
* @copyright © Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @version   GIT: 1.4.0
* @link      https://graph.microsoft.io/
*/
namespace Microsoft\Graph\Model;

/**
* SecureScore class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright © Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @version   Release: 1.4.0
* @link      https://graph.microsoft.io/
*/
class SecureScore extends Entity
{
    /**
    * Gets the activeUserCount
    *
    * @return int The activeUserCount
    */
    public function getActiveUserCount()
    {
        if (array_key_exists("activeUserCount", $this->_propDict)) {
            return $this->_propDict["activeUserCount"];
        } else {
            return null;
        }
    }
    
    /**
    * Sets the activeUserCount
    *
    * @param int $val The activeUserCount
    *
    * @return SecureScore
    */
    public function setActiveUserCount($val)
    {
        $this->_propDict["activeUserCount"] = intval($val);
        return $this;
    }
    

     /** 
     * Gets the averageComparativeScores
     *
     * @return array The averageComparativeScores
     */
    public function getAverageComparativeScores()
    {
        if (array_key_exists("averageComparativeScores", $this->_propDict)) {
           return $this->_propDict["averageComparativeScores"];
        } else {
            return null;
        }
    }
    
    /** 
    * Sets the averageComparativeScores
    *
    * @param AverageComparativeScore $val The averageComparativeScores
    *
    * @return SecureScore
    */
    public function setAverageComparativeScores($val)
    {
		$this->_propDict["averageComparativeScores"] = $val;
        return $this;
    }
    
    /**
    * Gets the azureTenantId
    *
    * @return string The azureTenantId
    */
    public function getAzureTenantId()
    {
        if (array_key_exists("azureTenantId", $this->_propDict)) {
            return $this->_propDict["azureTenantId"];
        } else {
            return null;
        }
    }
    
    /**
    * Sets the azureTenantId
    *
    * @param string $val The azureTenantId
    *
    * @return SecureScore
    */
    public function setAzureTenantId($val)
    {
        $this->_propDict["azureTenantId"] = $val;
        return $this;
    }
    

     /** 
     * Gets the controlScores
     *
     * @return array The controlScores
     */
    public function getControlScores()
    {
        if (array_key_exists("controlScores", $this->_propDict)) {
           return $this->_propDict["controlScores"];
        } else {
            return null;
        }
    }
    
    /** 
    * Sets the controlScores
    *
    * @param ControlScore $val The controlScores
    *
    * @return SecureScore
    */
    public function setControlScores($val)
    {
		$this->_propDict["controlScores"] = $val;
        return $this;
    }
    
    /**
    * Gets the createdDateTime
    *
    * @return \DateTime The createdDateTime
    */
    public function getCreatedDateTime()
    {
        if (array_key_exists("createdDateTime", $this->_propDict)) {
            if (is_a($this->_propDict["createdDateTime"], "\DateTime")) {
                return $this->_propDict["createdDateTime"];
            } else {
                $this->_propDict["createdDateTime"] = new \DateTime($this->_propDict["createdDateTime"]);
                return $this->_propDict["createdDateTime"];
            }
        }
        return null;
    }
    
    /**
    * Sets the createdDateTime
    *
    * @param \DateTime $val The createdDateTime
    *
    * @return SecureScore
    */
    public function setCreatedDateTime($val)
    {
        $this->_propDict["createdDateTime"] = $val;
        return $this;
    }
    
    /**
    * Gets the currentScore
    *
    * @return float The currentScore
    */
    public function getCurrentScore()
    {
        if (array_key_exists("currentScore", $this->_propDict)) {
            return $this->_propDict["currentScore"];
        } else {
            return null;
        }
    }
    
    /**
    * Sets the currentScore
    *
    * @param float $val The currentScore
    *
    * @return SecureScore
    */
    public function setCurrentScore($val)
    {
        $this->_propDict["currentScore"] = $val;
        return $this;
    }
    
    /**
    * Gets the enabledServices
    *
    * @return string The enabledServices
    */
    public function getEnabledServices()
    {
        if (array_key_exists("enabledServices", $this->_propDict)) {
            return $this->_propDict["enabledServices"];
        } else {
            return null;
        }
    }
    
    /**
    * Sets the enabledServices
    *
    * @param string $val The enabledServices
    *
    * @return SecureScore
    */
    public function setEnabledServices($val)
    {
        $this->_propDict["enabledServices"] = $val;
        return $this;
    }
    
    /**
    * Gets the licensedUserCount
    *
    * @return int The licensedUserCount
    */
    public function getLicensedUserCount()
    {
        if (array_key_exists("licensedUserCount", $this->_propDict)) {
            return $this->_propDict["licensedUserCount"];
        } else {
            return null;
        }
    }
    
    /**
    * Sets the licensedUserCount
    *
    * @param int $val The licensedUserCount
    *
    * @return SecureScore
    */
    public function setLicensedUserCount($val)
    {
        $this->_propDict["licensedUserCount"] = intval($val);
        return $this;
    }
    
    /**
    * Gets the maxScore
    *
    * @return float The maxScore
    */
    public function getMaxScore()
    {
        if (array_key_exists("maxScore", $this->_propDict)) {
            return $this->_propDict["maxScore"];
        } else {
            return null;
        }
    }
    
    /**
    * Sets the maxScore
    *
    * @param float $val The maxScore
    *
    * @return SecureScore
    */
    public function setMaxScore($val)
    {
        $this->_propDict["maxScore"] = $val;
        return $this;
    }
    
    /**
    * Gets the vendorInformation
    *
    * @return SecurityVendorInformation The vendorInformation
    */
    public function getVendorInformation()
    {
        if (array_key_exists("vendorInformation", $this->_propDict)) {
            if (is_a($this->_propDict["vendorInformation"], "Microsoft\Graph\Model\SecurityVendorInformation")) {
                return $this->_propDict["vendorInformation"];
            } else {
                $this->_propDict["vendorInformation"] = new SecurityVendorInformation($this->_propDict["vendorInformation"]);
                return $this->_propDict["vendorInformation"];
            }
        }
        return null;
    }
    
    /**
    * Sets the vendorInformation
    *
    * @param SecurityVendorInformation $val The vendorInformation
    *
    * @return SecureScore
    */
    public function setVendorInformation($val)
    {
        $this->_propDict["vendorInformation"] = $val;
        return $this;
    }
    
}