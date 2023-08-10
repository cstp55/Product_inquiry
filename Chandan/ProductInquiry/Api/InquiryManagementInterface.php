<?php
namespace Chandan\ProductInquiry\Api;

interface InquiryManagementInterface
{
    public const EMAIL = 'email';
    public const SUBJECT = 'subject';
    public const NAME = 'name';
    public const MESSAGE = 'message';
    public const INQUIRY_ID = 'inquiry_id';
    /**
     * Submit an inquiry
     *
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public function submitInquiry($name, $email, $subject, $message);

    public function setProductId($enquiry_id);
    
    public function getProductId();

    public function setInquiryId($enquiry_id);

    public function getInquiryId();
    /**
     * Get the inquiry name
     *
     * @return string
     */
    public function getName();

    /**
     * Set the inquiry name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get the inquiry email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set the inquiry email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get the inquiry subject
     *
     * @return string
     */
    public function getSubject();

    /**
     * Set the inquiry subject
     *
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject);

    /**
     * Get the inquiry message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set the inquiry message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);
}
