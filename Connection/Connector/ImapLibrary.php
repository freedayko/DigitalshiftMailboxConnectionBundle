<?php

namespace Digitalshift\MailboxConnectionBundle\Connection\Connector;

/**
 * ImapLibrary
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class ImapLibrary
{
    /**
     * @param string $connectionString
     * @param string $username
     * @param string $password
     * @param integer $flags
     * @return resource
     */
    public function imapOpen($connectionString, $username, $password, $flags)
    {
        return imap_open($connectionString, $username, $password, $flags);
    }

    /**
     * @param resource $imapResource
     * @param string $path
     */
    public function imapReopen($imapResource, $path)
    {
        imap_reopen($imapResource, $path);
    }

    /**
     * @param resource $imapResource
     * @return bool
     */
    public function imapClose($imapResource)
    {
        return imap_close($imapResource);
    }

    /**
     * @param resource $imapResource
     * @param string $mailbox
     * @param string $pattern
     * @return array
     */
    public function imapList($imapResource, $mailbox, $pattern)
    {
        return imap_list($imapResource, $mailbox, $pattern);
    }

    /**
     * @param resource $imapResource
     * @return object
     */
    public function imapCheck($imapResource)
    {
        return imap_check($imapResource);
    }

    /**
     * @param resource $imapResource
     * @param string $sequence
     * @param integer $options
     * @return array
     */
    public function imapFetchOverview($imapResource, $sequence, $options)
    {
        return imap_fetch_overview($imapResource, $sequence, $options);
    }

    /**
     * @param resource $imapResource
     * @param integer $messageNumber
     * @param boolean $isUid
     * @return string
     */
    public function imapFetchHeader($imapResource, $messageNumber, $isUid = false)
    {
        $options = ($isUid) ? FT_UID : 0;

        return imap_fetchheader($imapResource, $messageNumber, $options);
    }

    /**
     * @param resource $imapResource
     * @param integer $messageNumber
     * @param boolean $isUid
     * @return string
     */
    public function imapBody($imapResource, $messageNumber, $isUid = false)
    {
        $options = ($isUid) ? FT_UID : 0;

        return imap_body($imapResource, $messageNumber, $options);
    }

    /**
     * @param resource $imapResource
     * @return object
     */
    public function imapMailboxMsgInfo($imapResource)
    {
        return imap_mailboxmsginfo($imapResource);
    }

    /**
     * @param $imapResource
     * @param $messageNumber
     * @return int
     */
    public function imapUid($imapResource, $messageNumber)
    {
        return imap_uid($imapResource, $messageNumber);
    }
    
    /**
     * @param resource $imapResource
     * @param int $messageNumber
     * @param bool $isUid
     * @return bool
     */    
    public function imapDelete($imapResource, $messageNumber, $isUid = false)
    {
        $options = ($isUid) ? FT_UID : 0;

        return imap_delete($imapResource, $messageNumber, $options);
    }
    
    /**
     * 
     * @param resource $imapResource
     * @return bool
     */
    public function imapExpunge($imapResource)
    {
        return imap_expunge($imapResource);
    }
}
