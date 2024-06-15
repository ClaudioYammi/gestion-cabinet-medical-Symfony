<?php
    // src/Form/Transformer/ImageFileTransformer.php
namespace App\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageFileTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        // Transforme l'instance de File en une chaîne de caractères (le nom du fichier)
        if ($value instanceof File) {
            return $value->getFilename();
        }

        return $value;
    }

    public function reverseTransform($value)
    {
        // Transforme la chaîne de caractères (le nom du fichier) en une instance de File
        if ($value instanceof UploadedFile) {
            return $value;
        }

        // Vous pouvez personnaliser cette logique pour gérer les cas où la valeur est déjà une instance de File

        return null;
    }
}