<?php

namespace Digitalshift\MailboxConnectionBundle\Entity;

/**
 * Message
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class MimeMessage
{
    const MIME_TYPE_HTML = 'text/html';
    const MIME_TYPE_PLAIN = 'text/plain';
    const MIME_TYPE_IMAGE = 'image/*';
    const MIME_TYPE_AUDIO = 'audio/*';
    const MIME_TYPE_VIDEO = 'video/*';
    const MIME_TYPE_APPLICATION = 'application/*';

    const ATTACHMENT_EMBEDDED = 1;
    const ATTACHMENT_EXTENDED = 2;

    /**
     * path to mailbox where message is located
     *
     * @var string
     */
    private $mailboxPath;

    /**
     * uid of message in mailbox
     *
     * @var mixed
     */
    private $mailboxUid;

    /**
     * parent folder
     *
     * @var Folder
     */
    private $mailboxFolder;

    /**
     * mail headers
     *
     * @var MimeMessageHeaders
     */
    private $header;

    /**
     * mail mime-parts
     *
     * @var \Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePartCollection
     */
    private $content;

    /**
     * @param MimeMessageHeaders $header
     * @param MimeMessagePartCollection $content
     * @param $mailboxPath
     * @param $mailboxUid
     * @param Folder $mailboxFolder
     */
    public function __construct(
        MimeMessageHeaders $header,
        MimeMessagePartCollection $content,
        $mailboxPath = null,
        $mailboxUid = null,
        Folder $mailboxFolder = null
    ) {
        $this->header = $header;
        $this->content = $content;

        $this->mailboxPath = $mailboxPath;
        $this->mailboxUid = $mailboxUid;

        $this->mailboxFolder = $mailboxFolder;
    }

    /**
     * hydrate receive-date from headers
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return new \DateTime($this->header->get('Date'));
    }

    /**
     * hydrate subject from headers
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->header->get('Subject');
    }

    /**
     * hydrate sender from headers
     *
     * @return string
     */
    public function getSender()
    {
        return $this->header->get('From');
    }

    /**
     * @param string $mailboxPath
     */
    public function setMailboxPath($mailboxPath)
    {
        $this->mailboxPath = $mailboxPath;
    }

    /**
     * @return string
     */
    public function getMailboxPath()
    {
        return $this->mailboxPath;
    }

    /**
     * @param mixed $mailboxUid
     */
    public function setMailboxUid($mailboxUid)
    {
        $this->mailboxUid = $mailboxUid;
    }

    /**
     * @return mixed
     */
    public function getMailboxUid()
    {
        return $this->mailboxUid;
    }

    /**
     * @param \Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePartCollection $content
     */
    public function setContent(MimeMessagePartCollection $content)
    {
        $this->content = $content;
    }

    /**
     * @return \Digitalshift\MailboxConnectionBundle\Entity\MimeMessagePartCollection
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \Digitalshift\MailboxConnectionBundle\Entity\MimeMessageHeaders $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return \Digitalshift\MailboxConnectionBundle\Entity\MimeMessageHeaders
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param \Digitalshift\MailboxConnectionBundle\Entity\Folder $mailboxFolder
     */
    public function setMailboxFolder(Folder $mailboxFolder)
    {
        $this->mailboxFolder = $mailboxFolder;
    }

    /**
     * @return \Digitalshift\MailboxConnectionBundle\Entity\Folder
     */
    public function getMailboxFolder()
    {
        return $this->mailboxFolder;
    }

    /**
     * hydrate plain-content from mime parts
     *
     * @return string
     */
    public function getPlainContent()
    {
        return $this->content->getPartsWithType(self::MIME_TYPE_PLAIN);
    }

    /**
     * hydrate html-content from mime parts
     *
     * @return string
     */
    public function getHtmlContent()
    {
        return $this->content->getPartsWithType(self::MIME_TYPE_HTML);
    }

    /**
     * hydrate attachments from mime parts
     *
     * @param integer $attachmentType
     *
     * @return string
     */
    public function getAttachmentMimeParts($attachmentType = self::ATTACHMENT_EXTENDED)
    {
        return $this->content->getPartsWithAttachment($attachmentType);
    }
} 