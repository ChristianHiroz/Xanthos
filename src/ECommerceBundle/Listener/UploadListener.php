<?php

namespace ECommerceBundle\Listener;

use ECommerceBundle\Entity\Category;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use ECommerceBundle\Entity\Product;
use ECommerceBundle\Services\Uploader;

class UploadListener
{
    private $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities or Category entity
        if ($entity instanceof Product) {
            $file = $entity->getFile();

            // only upload new files
            if (!$file instanceof UploadedFile) {
                return;
            }

            $fileName = $this->uploader->upload($file);
            $entity->setFile($fileName);
        }elseif ($entity instanceof Category) {
            $file = $entity->getPicture();

            // only upload new files
            if (!$file instanceof UploadedFile) {
                return;
            }

            $fileName = $this->uploader->upload($file);
            $entity->setPicture($fileName);

        }

        return;

    }
}