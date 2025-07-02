<?php


class media
{
    private $image;
    public $errors = [];
    private $extension;
    private $newImageName = "";



    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get the value of newImageName
     */
    public function getNewImageName()
    {
        return $this->newImageName;
    }


    public function validateOnSize($maxSize)
    {
        if ($this->image['size'] > $maxSize) {
            $this->errors['size'] = "<div class='alert alert-danger'> Too Large File , Max Size Is $maxSize.B </div>";
        }

        return $this;
    }

    public function validateOnExtension(array $validateExtensions)
    {
        $this->extension = pathinfo($this->image['name'], PATHINFO_EXTENSION);
        if (!in_array($this->extension, $validateExtensions)) {
            $this->errors['extension'] = " Sorry , available extensions is " . implode(' , ', $validateExtensions);
        }
        return $this;
    }
    public function upload($uploadedDir)
    {
        if (empty($this->errors)) {

            $this->newImageName = time() . '-' . $_SESSION['user']->id . '.' . $this->extension;
            $path = "assets/img/$uploadedDir/$this->newImageName";
            move_uploaded_file($this->image['tmp_name'], $path);
        }
        return $this;
    }
}