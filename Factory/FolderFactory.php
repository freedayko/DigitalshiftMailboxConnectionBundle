<?php


namespace Digitalshift\MailboxConnectionBundle\Factory;

use Digitalshift\MailboxConnectionBundle\Entity\Folder;

/**
 * FolderFactory
 *
 * @author Soeren Helbig <Soeren.Helbig@digitalshift.de>
 * @copyright Digitalshift (c) 2014
 */
class FolderFactory
{
    /**
     * @var MimeMessageFactory
     */
    private $mimeMessageFactory;

    /**
     * @param MimeMessageFactory $mimeMessageFactory
     */
    public function __construct(MimeMessageFactory $mimeMessageFactory)
    {
        $this->mimeMessageFactory = $mimeMessageFactory;
    }

    /**
     * @param string $folderPath
     * @param array $subFolders
     * @param array $messages
     * @return Folder
     */
    public function byImapFolderListAndMessageList($folderPath, array $subFolders, array $messages)
    {
        $folderInstance = new Folder();
        $folderInstance->setPath($folderPath);
        $folderInstance->setName(
            $this->hydrateFolderNameFromPath($folderPath)
        );

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
        foreach ($subFolders as $subFolderPath) {
            $subFolderInstance = new Folder();
            $subFolderInstance->setPath($subFolderPath);
            $subFolderInstance->setName(
                $this->hydrateFolderNameFromPath($subFolderPath)
            );
            $subFolderInstance->setSynchronized(false);

            $folder->addSubFolder($subFolderInstance);
        }
    }

    /**
     * @param string $path
     * @return string
     */
    private function hydrateFolderNameFromPath($path)
    {
        $pathParts = explode('.', $path);

        return (count($pathParts) > 1) ? end($pathParts) : $path;
    }

    /**
     * @param Folder $folder
     * @param array $messages
     */
    private function setMessagesByMessageList(Folder $folder, array $messages)
    {
        foreach ($messages as $message) {
            $messageInstance = $this->mimeMessageFactory->byRawMessage($message, $message->mailboxPath, $message->mailboxUid, $folder);
            $folder->addMessage($messageInstance);
        }
    }
} 