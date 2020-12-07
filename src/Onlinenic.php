<?php

namespace Pezhvak\OnlinenicApi;

use GuzzleHttp\Client;
use stdClass;

/**
 * Class Onlinenic.
 *
 * @author Pezhvak <pezhvak@imvx.org>
 * based on https://www.onlinenic.com/cp_english/template_api/download/Onlinenic_API_v4.0_Reseller_Guide.pdf
 */
class Onlinenic
{
    private const ENDPOINT = 'https://api.onlinenic.com/api4/{resource}/index.php?command={command}';
    private const ENDPOINT_SANDBOX = 'https://ote.onlinenic.com/api4/{resource}/index.php?command={command}';
    private $account_id;
    private $password;
    private $api_key;
    private $sandbox;

    /**
     * OnlineNic constructor.
     *
     * @param string $account_id Your onlinenic account id
     * @param string $password   Your onlinenic account password
     * @param string $api_key    Your onlinenic api key
     * @param bool   $sandbox    Enable Sandbox Mode
     */
    public function __construct(string $account_id, string $password, string $api_key, bool $sandbox = false)
    {
        $this->account_id = $account_id;
        $this->password = $password;
        $this->api_key = $api_key;
        $this->sandbox = $sandbox;

        if ($sandbox) {
            // set default sandbox credentials
            $this->account_id = '10578';
            $this->password = '654123';
            $this->api_key = 'v}k5s(`ipc$G~koH';
        }
    }

    /**
     * Parse Certificate Signing Request.
     *
     * @param $csr string csr string
     *
     * @return stdClass result
     */
    public function parseCSR(string $csr): stdClass
    {
        return $this->_request(Resources::SSL, 'parseCsr', compact('csr', 'csr'));
    }

    /**
     * Return a List of valid Approval Email addresses.
     *
     * @param string $domain
     *
     * @return stdClass result
     */
    public function getApprovalEmailAddress(string $domain): stdClass
    {
        return $this->_request(Resources::SSL, 'getApprovalEmailList', compact('domain'));
    }

    /**
     * Order a new SSL.
     *
     * @param string      $product_id
     * @param int         $period          can be 12 or 24
     * @param int         $server_type
     * @param string      $csr
     * @param string      $approval_email
     * @param string      $dcv_method
     * @param string|null $admin_firstname
     * @param string|null $admin_lastname
     * @param string|null $admin_title
     * @param string|null $admin_phone
     * @param string|null $admin_email
     * @param string|null $tech_firstname
     * @param string|null $tech_lastname
     * @param string|null $tech_title
     * @param string|null $tech_phone
     * @param string|null $tech_email
     * @param string|null $sans
     * @param string|null $duns
     * @param string|null $dba
     * @param string|null $org_name
     * @param string|null $org_address_1
     * @param string|null $org_address_2
     * @param string|null $org_city
     * @param string|null $org_state
     * @param string|null $org_country
     * @param string|null $org_phone
     * @param string|null $org_fax
     * @param string|null $org_postalcode
     *
     * @return stdClass result
     */
    public function orderSSL(
        string $product_id,
        int $period,
        int $server_type,
        string $csr,
        string $approval_email,
        string $dcv_method = DCVMethods::Email,
        string $admin_firstname = null,
        string $admin_lastname = null,
        string $admin_title = null,
        string $admin_phone = null,
        string $admin_email = null,
        string $tech_firstname = null,
        string $tech_lastname = null,
        string $tech_title = null,
        string $tech_phone = null,
        string $tech_email = null,
        string $sans = null,
        string $duns = null,
        string $dba = null,
        string $org_name = null,
        string $org_address_1 = null,
        string $org_address_2 = null,
        string $org_city = null,
        string $org_state = null,
        string $org_country = null,
        string $org_phone = null,
        string $org_fax = null,
        string $org_postalcode = null
    ): stdClass
    {
        return $this->_request(Resources::SSL, 'orderSSL', [
            'productid'       => $product_id,
            'period'          => $period,
            'servertype'      => $server_type,
            'dcvmethod'       => $dcv_method,
            'csr'             => $csr,
            'adminfirstname'  => $admin_firstname,
            'adminlastname'   => $admin_lastname,
            'admintitle'      => $admin_title,
            'adminphone'      => $admin_phone,
            'adminemail'      => $admin_email,
            'techfirstname'   => $tech_firstname,
            'techlastname'    => $tech_lastname,
            'techtitle'       => $tech_title,
            'techphone'       => $tech_phone,
            'techemail'       => $tech_email,
            'sans'            => $sans,
            'duns'            => $duns,
            'dba'             => $dba,
            'orgname'         => $org_name,
            'orgaddressline1' => $org_address_1,
            'orgaddressline2' => $org_address_2,
            'orgcity'         => $org_city,
            'orgstate'        => $org_state,
            'orgcountry'      => $org_country,
            'orgphone'        => $org_phone,
            'orgfax'          => $org_fax,
            'orgpostalcode'   => $org_postalcode,
            'approvalemail'   => $approval_email,
        ]);
    }

    /**
     * Renew an existing SSL.
     *
     * @param string      $order_id
     * @param int         $period          can be 12 or 24
     * @param string      $csr
     * @param string      $approval_email
     * @param string      $dcv_method
     * @param string|null $admin_firstname
     * @param string|null $admin_lastname
     * @param string|null $admin_title
     * @param string|null $admin_phone
     * @param string|null $admin_email
     * @param string|null $tech_firstname
     * @param string|null $tech_lastname
     * @param string|null $tech_title
     * @param string|null $tech_phone
     * @param string|null $tech_email
     * @param string|null $duns
     * @param string|null $org_name
     * @param string|null $org_address_1
     * @param string|null $org_address_2
     * @param string|null $org_city
     * @param string|null $org_state
     * @param string|null $org_country
     * @param string|null $org_phone
     * @param string|null $org_fax
     * @param string|null $org_postalcode
     *
     * @return stdClass result
     */
    public function renewSSL(
        string $order_id,
        int $period,
        string $csr,
        string $approval_email,
        string $dcv_method = DCVMethods::Email,
        string $admin_firstname = null,
        string $admin_lastname = null,
        string $admin_title = null,
        string $admin_phone = null,
        string $admin_email = null,
        string $tech_firstname = null,
        string $tech_lastname = null,
        string $tech_title = null,
        string $tech_phone = null,
        string $tech_email = null,
        string $duns = null,
        string $org_name = null,
        string $org_address_1 = null,
        string $org_address_2 = null,
        string $org_city = null,
        string $org_state = null,
        string $org_country = null,
        string $org_phone = null,
        string $org_fax = null,
        string $org_postalcode = null
    ): stdClass
    {
        return $this->_request(Resources::SSL, 'renewSSL', [
            'orderid'         => $order_id,
            'period'          => $period,
            'csr'             => $csr,
            'dcvmethod'       => $dcv_method,
            'adminfirstname'  => $admin_firstname,
            'adminlastname'   => $admin_lastname,
            'admintitle'      => $admin_title,
            'adminphone'      => $admin_phone,
            'adminemail'      => $admin_email,
            'techfirstname'   => $tech_firstname,
            'techlastname'    => $tech_lastname,
            'techtitle'       => $tech_title,
            'techphone'       => $tech_phone,
            'techemail'       => $tech_email,
            'duns'            => $duns,
            'orgname'         => $org_name,
            'orgaddressline1' => $org_address_1,
            'orgaddressline2' => $org_address_2,
            'orgcity'         => $org_city,
            'orgstate'        => $org_state,
            'orgcountry'      => $org_country,
            'orgphone'        => $org_phone,
            'orgfax'          => $org_fax,
            'orgpostalcode'   => $org_postalcode,
            'approvalemail'   => $approval_email,
        ]);
    }

    /**
     * Get SSL Product Details.
     *
     * @param string|null $productid
     * @param int|null    $page
     *
     * @return stdClass
     */
    public function getSSLProductDetails(string $productid = null, int $page = null): stdClass
    {
        return $this->_request(Resources::SSL, 'getSSLProductDetails', compact('productid', 'page'));
    }

    /**
     * Get SSL Order ID.
     *
     * @param string $domain
     *
     * @return stdClass
     */
    public function getSSLOrderID(string $domain): stdClass
    {
        return $this->_request(Resources::SSL, 'getSSLOrderId', compact('domain'));
    }

    /**
     * Get SSL Order Info.
     *
     * @param string $orderid
     *
     * @return stdClass
     */
    public function getSSLOrderInfo(string $orderid): stdClass
    {
        return $this->_request(Resources::SSL, 'getSSLOrderInfo', compact('orderid'));
    }

    /**
     * Get SSL Order List.
     *
     * @param int|null $page
     *
     * @return stdClass
     */
    public function getSSLOrderList(int $page = null): stdClass
    {
        return $this->_request(Resources::SSL, 'getSSLOrderList', compact('page'));
    }

    /**
     * Get SSL Price.
     *
     * @param string      $productid
     * @param int         $period       can be 12 or 24
     * @param string      $country
     * @param string|null $wildcardsans
     * @param string|null $sans
     *
     * @return stdClass
     */
    public function getSSLPrice(string $productid, int $period, string $country, string $wildcardsans = null, string $sans = null): stdClass
    {
        return $this->_request(Resources::SSL, 'getSSLPrice', compact('productid', 'period', 'country', 'wildcardsans', 'sans'));
    }

    /**
     * Resend Approval Email.
     *
     * @param string $orderid
     *
     * @return stdClass
     */
    public function resendSSLApprovalEmail(string $orderid): stdClass
    {
        return $this->_request(Resources::SSL, 'resendApprovalEmail', compact('orderid'));
    }

    /**
     * Reissue SSL.
     *
     * this is used to regenerate an ordered ssl certificate for another server
     *
     * @param string      $orderid
     * @param string      $csr
     * @param string      $approvalemail
     * @param int|null    $webservertype
     * @param string|null $dcvmethod
     *
     * @return stdClass
     */
    public function reissueSSL(string $orderid, string $csr, string $approvalemail, int $webservertype = null, string $dcvmethod = null): stdClass
    {
        return $this->_request(Resources::SSL, 'reissueSSL', compact('orderid', 'csr', 'approvalemail', 'webservertype', 'dcvmethod'));
    }

    /**
     * Cancel SSL.
     *
     * Here we want to talk about the Difference between Cancel and revoke. A refund for the certificate Order can be request for in-progress order and
     * order issued within 30 days refund period. A revoke command allows partners to revoke an issued SSL certificate. You maybe have several
     * SSL/TLS certificates issued, When a certificate's corresponding private key is no longer safe, you should revoke the certificate. This can happen
     * for a few different reasons. For instance, you might accidentally share the private key on a public website; hackers might copy the private key off
     * of your servers; or hackers might take temporary control over your servers or your DNS configuration, and use that to validate and issue a
     * certificate for which they hold the private key.
     *
     * @param string $orderid
     * @param string $reason        'key Compromise' or 'cessation of service'
     * @param string $approvalemail
     *
     * @return stdClass
     */
    public function cancelSSL(string $orderid, string $reason, string $approvalemail = null): stdClass
    {
        return $this->_request(Resources::SSL, 'cancelSSL', compact('orderid', 'reason', 'approvalemail'));
    }

    /**
     * Change Validation Email.
     *
     * @param string $orderid
     * @param string $newaddress
     *
     * @return stdClass
     */
    public function changeSSLValidationEmail(string $orderid, string $newaddress): stdClass
    {
        return $this->_request(Resources::SSL, 'changeValidationEmail', compact('orderid', 'reason', 'newaddress'));
    }

    /**
     * Get SSL Certificate.
     *
     * @param string $orderid
     *
     * @return stdClass
     */
    public function getSSLCertificate(string $orderid): stdClass
    {
        return $this->_request(Resources::SSL, 'getSSLCert', compact('orderid'));
    }

    /**
     * Revoke SSL Certificate.
     *
     * Revoke an existing Certificate. This method can be used for one of the following purposes You may use this method to revoke if an existing
     * cert or the corresponding private Key has been compromised or has been at risk of compromise.
     *
     * @param string      $orderid
     * @param string      $reason       can be 'key Compromise' or 'cessation of service'
     * @param string|null $cert         required by geotrust
     * @param string|null $revokemethod can be 'DNS' or 'Email'
     *
     * @return stdClass
     */
    public function revokeSSLCertificate(string $orderid, string $reason, string $cert = null, string $revokemethod = null): stdClass
    {
        if ($cert) {
            base64_encode($cert);
        }

        return $this->_request(Resources::SSL, 'revokeSSL', compact('orderid', 'reason', 'revokemethod'));
    }

    /**
     * Check Domain Availability.
     *
     * @param string   $domain Domain Name
     * @param int|null $op     Operation Flag
     *
     * @return stdClass result
     */
    public function checkDomain(string $domain, int $op = null): stdClass
    {
        return $this->_request(Resources::Domain, 'checkDomain', compact('domain', 'op'));
    }

    /**
     * Register a new domain.
     *
     * @param string $domain                domain name to register
     * @param int    $period                [1-10] years to register domain for
     * @param array  $dns                   [2-6] dns servers to set for
     * @param string $registrant_contact_id registrant contact id
     * @param string $admin_contact_id      administrator contact id
     * @param string $tech_contact_id       technical contact id
     * @param string $billing_contact_id    billing contact id
     * @param string $premium_fee           onlinenic requires you to send the amount you are going to pay if domain is premium
     *
     * @return stdClass result
     */
    public function registerDomain(
        string $domain,
        int $period,
        array $dns,
        string $registrant_contact_id,
        string $admin_contact_id,
        string $tech_contact_id,
        string $billing_contact_id,
        string $premium_fee = null
    ): stdClass
    {
        $dnss = [];
        $i = 0;
        foreach ($dns as $d) {
            $i++;
            $dnss['dns'.$i] = $d;
        }

        return $this->_request(Resources::Domain, 'registerDomain', [
            'domain' => $domain,
            'period' => $period,
            'fee'    => $premium_fee,
        ] + $dnss + [
            'registrant' => $registrant_contact_id,
            'admin'      => $admin_contact_id,
            'tech'       => $tech_contact_id,
            'billing'    => $billing_contact_id,
        ]);
    }

    /**
     * Renew Domain.
     *
     * @param string      $domain      domain name that you own
     * @param int         $period      in years
     * @param string|null $premium_fee
     *
     * @return stdClass
     */
    public function renewDomain(string $domain, int $period, string $premium_fee = null): stdClass
    {
        return $this->_request(Resources::Domain, 'renewDomain', [
            'domain' => $domain,
            'period' => $period,
            'fee'    => $premium_fee,
        ]);
    }

    /**
     * Get Domain Details.
     *
     * @param string $domain
     *
     * @return stdClass
     */
    public function getDomainDetails(string $domain): stdClass
    {
        return $this->_request(Resources::Domain, 'infoDomain', compact('domain'));
    }

    /**
     * Transfer Auth Code.
     *
     * @param string $domain
     *
     * @return stdClass
     */
    public function getDomainAuthCode(string $domain): stdClass
    {
        return $this->_request(Resources::Domain, 'getAuthCode', compact('domain'));
    }

    /**
     * Modify Domain Transfer Auth Code.
     *
     * @param string $domain   domain name that you own
     * @param string $authcode the new auth code
     *
     * @return stdClass
     */
    public function modifyDomainAuthCode(string $domain, string $authcode): stdClass
    {
        return $this->_request(Resources::Domain, 'updateAuthCode', compact('domain', 'authcode'));
    }

    /**
     * Domain Transfer Lock Status.
     *
     * @param string $domain domain name that you own
     * @param bool   $locked whether domain transfer should be locked or not
     *
     * @return stdClass
     */
    public function setDomainTransferLockStatus(string $domain, bool $locked): stdClass
    {
        return $this->_request(Resources::Domain, 'updateDomainStatus', [
            'domain' => $domain,
            'ctp'    => $locked ? 'Y' : 'N',
        ]);
    }

    /**
     * Update Domain DNS.
     *
     * @param string $domain domain name that you own
     * @param array  $dns    two should be provided at least
     *
     * @return stdClass
     */
    public function updateDomainDNS(string $domain, array $dns): stdClass
    {
        $dnss = [];
        $i = 0;
        foreach ($dns as $d) {
            $i++;
            $dnss['dns'.$i] = $d;
        }

        return $this->_request(Resources::Domain, 'updateDomainDns', [
            'domain' => $domain,
        ] + $dnss);
    }

    /**
     * Set Domain Password for Enduser Pane.
     *
     * @param string $domain
     * @param string $password
     *
     * @return stdClass
     */
    public function setDomainPanelPassword(string $domain, string $password): stdClass
    {
        return $this->_request(Resources::Domain, 'setDomainPassword', compact('domain', 'password'));
    }

    /**
     * Create Contact ID.
     *
     * @param string      $domain            domain name or tld
     * @param string      $name
     * @param string      $organization
     * @param string      $country_two_digit
     * @param string      $province
     * @param string      $city
     * @param string      $street
     * @param string      $postal_code
     * @param string      $phone
     * @param string      $fax
     * @param string      $email
     * @param string|null $apppurpose        Peculiar Parameter For .us domains, use USDomainPurpose for valid values
     * @param string|null $nexuscategory     Peculiar Parameter For .us domains
     * @param string|null $orgtype           Peculiar Parameter For .uk domains use UKDomainOrganizationType for valid values
     * @param null        $license           Peculiar Parameter For .uk domains, Business License number for organizations
     *
     * @return stdClass
     */
    public function createContactID(
        string $domain,
        string $name,
        string $organization,
        string $country_two_digit,
        string $province,
        string $city,
        string $street,
        string $postal_code,
        string $phone,
        string $fax,
        string $email,
        string $apppurpose = null,
        string $nexuscategory = null,
        string $orgtype = null,
        $license = null
    ): stdClass
    {
        $ext = $this->_getDomainExtension($domain);
        // corrupt USA regime is trying to suppress innocent iranian people, it's unfair! down with USA Government.
        if (strtoupper($country_two_digit) == 'IR') {
            $country_two_digit = 'AQ';
        } // Antarctica is untouched ;)
        if (substr($phone, 0, 3) == '+98') {
            $phone = str_replace('+98.', '+0.98', $phone);
        }
        if (substr($fax, 0, 3) == '+98') {
            $fax = str_replace('+98.', '+0.98', $fax);
        }
        if (strtolower($province) == 'tehran') {
            $province = 'Tehraan';
        }
        if (strtolower($city) == 'tehran') {
            $city = 'Tehraan';
        }

        return $this->_request(Resources::Domain, 'createContact', [
            'ext'           => $ext,
            'name'          => $name,
            'org'           => $organization,
            'country'       => $country_two_digit,
            'province'      => $province,
            'city'          => $city,
            'street'        => $street,
            'postalcode'    => $postal_code,
            'voice'         => $phone,
            'fax'           => $fax,
            'email'         => $email,
            'apppurpose'    => $apppurpose,
            'nexuscategory' => $nexuscategory,
            'orgtype'       => $orgtype,
            'license'       => $license,
        ]);
    }

    /**
     * Change Registrant Name.
     *
     * @param string $domain
     * @param string $name
     * @param string $regtype required only for .eu domains
     * @param string $org     required only for .eu domains use EUDomainRegType for available types
     * @param string $email   required only for .eu domains
     *
     * @return stdClass
     *
     * @todo this is not working i have opened an ticket for letting them know
     */
    public function changeRegistrantName(string $domain, string $name, string $regtype = null, string $org = null, string $email = null): stdClass
    {
        return $this->_request(Resources::Domain, 'changeRegistrant', compact('domain', 'name', 'regtype', 'org', 'email'));
    }

    /**
     * Get Contact ID Details.
     *
     * @param string $domain domain name that you own
     * @param $contactid id of the created contact
     *
     * @return stdClass
     */
    public function getContactDetails(string $domain, $contactid): stdClass
    {
        $ext = $this->_getDomainExtension($domain);

        return $this->_request(Resources::Domain, 'infoContact', compact('ext', 'contactid'));
    }

    /**
     * Change Domain Contacts.
     *
     * @param string $domain                domain that you own
     * @param string $registrant_contact_id
     * @param string $admin_contact_id
     * @param string $technical_contact_id
     * @param string $billing_contact_id
     *
     * @return stdClass
     */
    public function changeDomainContacts(
        string $domain,
        string $registrant_contact_id,
        string $admin_contact_id,
        string $technical_contact_id,
        string $billing_contact_id
    ): stdClass
    {
        return $this->_request(Resources::Domain, 'domainChangeContact', [
            'domain'     => $domain,
            'registrant' => $registrant_contact_id,
            'admin'      => $admin_contact_id,
            'tech'       => $technical_contact_id,
            'billing'    => $billing_contact_id,
        ]);
    }

    /**
     * Update Contact Details.
     *
     * @param string $domain            domain name that you own
     * @param string $contact_id
     * @param string $name
     * @param string $organization
     * @param string $country_two_digit
     * @param string $province
     * @param string $city
     * @param string $street
     * @param string $postal_code
     * @param string $phone
     * @param string $fax
     * @param string $email
     *
     * @return stdClass
     */
    public function updateContactDetails(
        string $domain,
        string $contact_id,
        string $name,
        string $organization,
        string $country_two_digit,
        string $province,
        string $city,
        string $street,
        string $postal_code,
        string $phone,
        string $fax,
        string $email
    ): stdClass
    {
        $ext = $this->_getDomainExtension($domain);

        return $this->_request(Resources::Domain, 'updateContact', [
            'ext'        => $ext,
            'contactid'  => $contact_id,
            'name'       => $name,
            'org'        => $organization,
            'country'    => $country_two_digit,
            'province'   => $province,
            'city'       => $city,
            'street'     => $street,
            'postalcode' => $postal_code,
            'voice'      => $phone,
            'fax'        => $fax,
            'email'      => $email,
        ]);
    }

    /**
     * Domain Transfer In.
     *
     * @param string      $domain      domain name that you want to transfer in
     * @param string      $auth_code   transfer password
     * @param string      $contact_id
     * @param string|null $premium_fee
     *
     * @return stdClass
     */
    public function domainTransferIn(string $domain, string $auth_code, string $contact_id, string $premium_fee = null): stdClass
    {
        return $this->_request(Resources::Domain, 'transferDomain', [
            'domain'    => $domain,
            'password'  => $auth_code,
            'contactid' => $contact_id,
            'fee'       => $premium_fee,
        ]);
    }

    /**
     * Get Domain Transfer Status.
     *
     * @param string $domain   domain name that you requested to transfer in
     * @param string $password auth code of the transfer
     *
     * @return stdClass
     */
    public function domainTransferStatus(string $domain, string $password): stdClass
    {
        return $this->_request(Resources::Domain, 'queryTransferStatus', compact('domain', 'password'));
    }

    /**
     * Cancel Domain Transfer In.
     *
     * @param string $domain
     * @param string $password
     *
     * @return stdClass
     */
    public function cancelDomainTransfer(string $domain, string $password): stdClass
    {
        return $this->_request(Resources::Domain, 'cancelDomainTransfer', compact('domain', 'password'));
    }

    /**
     * Get Private Name Server Details.
     *
     * @param string      $ns     name server
     * @param string|null $domain domain required for exact tld detection, for normal tld and name sever it will be detected automatically
     *
     * @return stdClass
     */
    public function getPrivateNSDetails(string $ns, string $domain = null): stdClass
    {
        $ext = $domain ? $this->_getDomainExtension($domain) : $this->_getDomainExtension($this->_getDomainExtension($ns));

        return $this->_request(Resources::Domain, 'infoHost', [
            'hostname' => $ns,
            'ext'      => $ext,
        ]);
    }

    /**
     * Check Private Name Server Availability.
     *
     * @param string      $ns     name server to check
     * @param string|null $domain domain required for exact tld detection, for normal tld and name sever it will be detected automatically
     *
     * @return stdClass
     */
    public function checkPrivateNS(string $ns, string $domain = null): stdClass
    {
        $ext = $domain ? $this->_getDomainExtension($domain) : $this->_getDomainExtension($this->_getDomainExtension($ns));

        return $this->_request(Resources::Domain, 'checkHost', [
            'hostname' => $ns,
            'ext'      => $ext,
        ]);
    }

    /**
     * Create Private Name Server.
     *
     * @param string      $ns
     * @param string|null $ip
     * @param string|null $domain
     *
     * @return stdClass
     */
    public function createPrivateNS(string $ns, string $ip = null, string $domain = null): stdClass
    {
        $ext = $domain ? $this->_getDomainExtension($domain) : $this->_getDomainExtension($this->_getDomainExtension($ns));

        return $this->_request(Resources::Domain, 'createHost', [
            'hostname' => $ns,
            'ext'      => $ext,
            'addr'     => $ip,
        ]);
    }

    /**
     * Update Private Name Server IP.
     *
     * @param string      $ns     name server that you want to update
     * @param string|null $ip     ip address to add
     * @param string|null $domain
     *
     * @return stdClass
     */
    public function updatePrivateNSIP(string $ns, string $ip, string $domain = null): stdClass
    {
        $ext = $domain ? $this->_getDomainExtension($domain) : $this->_getDomainExtension($this->_getDomainExtension($ns));

        return $this->_request(Resources::Domain, 'updateHost', [
            'hostname' => $ns,
            'ext'      => $ext,
            'addaddr'  => $ip,
        ]);
    }

    /**
     * Update Private Name Server IP.
     *
     * @param string      $ns     name server that you want to update
     * @param string|null $ip     ip address to remove
     * @param string|null $domain
     *
     * @return stdClass
     */
    public function removePrivateNSIP(string $ns, string $ip, string $domain = null): stdClass
    {
        $ext = $domain ? $this->_getDomainExtension($domain) : $this->_getDomainExtension($this->_getDomainExtension($ns));

        return $this->_request(Resources::Domain, 'updateHost', [
            'hostname' => $ns,
            'ext'      => $ext,
            'remaddr'  => $ip,
        ]);
    }

    /**
     * Delete Private Name Server.
     *
     * @param string      $ns     name server that you want to update
     * @param string|null $domain
     *
     * @return stdClass
     */
    public function deletePrivateNS(string $ns, string $domain = null): stdClass
    {
        $ext = $domain ? $this->_getDomainExtension($domain) : $this->_getDomainExtension($this->_getDomainExtension($ns));

        return $this->_request(Resources::Domain, 'deleteHost', [
            'hostname' => $ns,
            'ext'      => $ext,
        ]);
    }

    /**
     * Send Request To Online Nic.
     *
     * @param string $resource resource of the api
     * @param $command string API Command
     * @param $params array Params of the command
     *
     * @return stdClass result of the executed command
     */
    private function _request(string $resource, string $command, array $params): stdClass
    {
        $timestamp = time();
        $token = md5($this->account_id.md5($this->password).$timestamp.$command);
        $client = new Client(['verify' => false]);
        $data = [
            'user'      => $this->account_id,
            'timestamp' => $timestamp,
            'apikey'    => $this->api_key,
            'token'     => $token,
        ];
        $data = $data + $params;

        return \GuzzleHttp\json_decode(
            $client->post(
                (strtr($this->sandbox ? self::ENDPOINT_SANDBOX : self::ENDPOINT, ['{resource}' => $resource, '{command}' => $command])),
                [
                    'form_params' => $data,
                ]
            )
                ->getBody()
                ->getContents()
        );
    }

    /**
     * Get Domain Extension.
     *
     * @param string $domain domain name
     *
     * @return string domain extension
     */
    private function _getDomainExtension(string $domain): string
    {
        return substr(strstr($domain, '.'), 1);
    }
}

abstract class OperationFlags
{
    const Register = 1;
    const Transfer = 2;
    const Renew = 3;
}

abstract class Resources
{
    const Domain = 'domain';
    const SSL = 'ssl';
}

abstract class DCVMethods
{
    const Email = 'Email';
    const File = 'File';
    const DNS = 'DNS';
    const Note = 'Note';
}

abstract class USDomainPurpose
{
    const BusinessUseForProfit = 'P1';
    const NonProfit = 'P2';
    const Club = 'P2';
    const Association = 'P2';
    const ReligiousOrganization = 'P2';
    const PersonalUse = 'P3';
    const EducationPurposes = 'P4';
    const GovernmentPurposes = 'P5';
}

abstract class UKDomainOrganizationType
{
    const LimitedCompany = 'LTD';
    const PublicLimitedCompany = 'PLC';
    const LimitedLiabilityPartnership = 'LLP';
    const IndustrialRegisteredCompany = 'IP';
    const ProvidentRegisteredCompany = 'IP';
    const School = 'SCH';
    const RegisteredCharity = 'RCHAR';
    const NonUKCorporation = 'FCORP';
}

abstract class EUDomainRegType
{
    const Individual = 'In';
    const Corporation = 'Co';
}

abstract class ServerType
{
    const AOL = 1;
    const Apache = 2;
    const ModSSL = 2;
    const ApacheSSL = 3;
    const C2NStronghold = 4;
    const Cisco3000SeriesVpnConcentrator = 5;
    const Citrix = 6;
    const CobaltRaq = 7;
    const CovalentServerSoftware = 8;
    const Ensim = 9;
    const HSphere = 10;
    const IBMHttpServer = 11;
    const IBMInternetConnectionServer = 12;
    const iPlanet = 13;
    const JavaWebServer = 14;
    const LotusDomino = 15;
    const LotusDominoGo = 16;
    const MicrosoftIIS1to4 = 17;
    const MicrosoftIIS5to6 = 18;
    const MicrosoftIIS7andLater = 19;
    const NetscapeEnterpriseServer = 20;
    const NetscapeFastTrack = 21;
    const Nginx = 22;
    const NovellWebServer = 23;
    const Oracle = 24;
    const Plesk = 25;
    const QuidProQuo = 26;
    const R3SslServer = 27;
    const RavenSSL = 28;
    const RedHatLinux = 29;
    const SAPWebApplicationServer = 30;
    const Tomcat = 31;
    const WebsiteProfessional = 32;
    const Webstar4 = 33;
    const WebTen = 34;
    const WHM = 35;
    const cPanel = 35;
    const ZeusWebServer = 36;
    const Other = -1;
}
