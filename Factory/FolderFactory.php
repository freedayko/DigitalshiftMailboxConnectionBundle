<?php

namespace Digitalshift\MailboxClientBundle\Factory;

use Digitalshift\MailboxClientBundle\Mailbox\Folder;

/**
 * FolderFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class FolderFactory
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @param MessageFactory $messageFactory
     */
    public function __construct(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param string $folder
     * @param array $subFolders
     * @param array $messages
     * @return Folder
     */
    public function byImapFolderListAndMessageList($folder, array $subFolders, array $messages)
    {
        $folderInstance = new Folder();
        $folderInstance->setPath($folder);
        $folderInstance->setSynchronized(true);

        $this->setSubFolderByFolderList($folderInstance, $subFolders);
        $this->setMessagesByMessageList($folderInstance, $messages);

        return $folderInstance;
    }

    /**
     * @param Folder $folder
     * @param array $subFolders
     */
    private function setSubFolderByFolderList(Folder $folder, array $subFolders)
    {
        foreach ($subFolders as $subFolder) {
            $subFolderInstance = new Folder();
            $subFolderInstance->setPath($subFolder);
            $subFolderInstance->setSynchronized(false);

            $folder->addSubFolder($subFolderInstance);
        }
    }

    /**
     * @param Folder $folder
     * @param array $messages
     */
    private function setMessagesByMessageList(Folder $folder, array $messages)
    {
        foreach ($messages as $message) {
            $messageInstance = $this->messageFactory->byRawMessage($message);
            $folder->addMessage($messageInstance);
        }
    }
} 