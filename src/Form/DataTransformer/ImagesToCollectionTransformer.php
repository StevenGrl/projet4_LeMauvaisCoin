<?php

namespace App\Form\DataTransformer;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Symfony\Component\Form\DataTransformerInterface;

class ImagesToCollectionTransformer implements DataTransformerInterface
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function transform($value): string
    {
        return implode(', ', $value);
    }

    public function reverseTransform($values): array
    {
        if (!empty($values)) {
            foreach ($values as $value) {
                $names = array_unique(array_filter(array_map('trim', explode(',', $value))));
            }

            $images = $this->imageRepository->findBy([
                'image' => $names
            ]);

            $newNames = array_diff($names, $images);

            foreach ($newNames as $name) {
                $image = new Image();
                $image->setImage($name);
                $images[] = $image;
            }

            return $images;
        }
        return [];
    }
}
