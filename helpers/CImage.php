<?php

namespace app\helpers;

use yii;

class CImage {

    public static function getImage($fname, $entity, $width = null, $height = null) {
        if (!$fname) {
            return null;
        }

        $fileurl = Yii::$app->request->getBaseUrl(true) . "/images/{$entity}/{$fname}";
        $filepath = Yii::$app->basePath . "/web/images/{$entity}/{$fname}";

        if (!$width || !$height) {
            return $fileurl;
        }

        // проверяем, есть ли папка
        $resized_filepath = Yii::$app->basePath . "/web/images/{$entity}/{$width}x{$height}";
        if (!file_exists($resized_filepath)) {
            mkdir($resized_filepath, 0755);
        }

        // проверяем, есть ли изображение
        $resized_imagepath = $resized_filepath . "/{$fname}";
        if (file_exists($resized_imagepath)) {
            return Yii::$app->request->getBaseUrl(true) . "/images/{$entity}/{$width}x{$height}/$fname";
        }

        return CImage::getResizeImage($fname, $entity, $width, $height);
    }

    public static function getResizeImage($file, $entity, $w, $h, $crop = false) {
        $filepath = Yii::$app->basePath . "/web/images/{$entity}/";

        list($width, $height) = getimagesize($filepath . $file);

        if ($w > $width || $h > $height) {
            return Yii::$app->request->getBaseUrl(true) . "/images/{$entity}/$file";
        }

        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }

        $type = strtolower(substr(strrchr($file, "."), 1));
        if ($type == 'jpeg') {
            $type = 'jpg';
        }
        
        $img_type = exif_imagetype($filepath . $file);

        switch ($img_type) {
            // gif
            case 1 : $src = imagecreatefromgif($filepath . $file);
                break;
            // jpg
            case 2 : 
                $src = imagecreatefromjpeg($filepath . $file);
                break;
            // png
            case 3 : $src = imagecreatefrompng($filepath . $file);
                break;
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        
        if($type == 'png') {
            imagealphablending($dst, false);
            imagesavealpha($dst,true);
            $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefilledrectangle($dst, 0, 0, $newwidth, $newheight, $transparent);
        }
        
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        $new_filepath = $filepath . "{$w}x{$h}/";
        switch ($type) {
            case 'gif': imagegif($dst, $new_filepath . $file);
                break;
            case 'jpg': imagejpeg($dst, $new_filepath . $file, 100);
                break;
            case 'png': imagepng($dst, $new_filepath . $file);
                break;
        }


        return Yii::$app->request->getBaseUrl(true) . "/images/{$entity}/{$w}x{$h}/$file";
    }

    public static function resizeImage($file, $entity, $w, $h, $crop = false) {
        $filepath = Yii::$app->basePath . "/web/images/{$entity}/";

        list($width, $height) = getimagesize($filepath . $file);

        if ($w > $width || $h > $height) {
            return Yii::$app->request->getBaseUrl(true) . "/images/{$entity}/$file";
        }

        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }

        $type = strtolower(substr(strrchr($file, "."), 1));
        if ($type == 'jpeg') {
            $type = 'jpg';
        }

        switch ($type) {
            case 'gif': $src = imagecreatefromgif($filepath . $file);
                break;
            case 'jpg': $src = imagecreatefromjpeg($filepath . $file);
                break;
            case 'png': $src = imagecreatefrompng($filepath . $file);
                break;
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        $new_filepath = $filepath;
        switch ($type) {
            case 'gif': imagegif($dst, $new_filepath . $file);
                break;
            case 'jpg': imagejpeg($dst, $new_filepath . $file, 100);
                break;
            case 'png': imagepng($dst, $new_filepath . $file);
                break;
        }


        return Yii::$app->request->getBaseUrl(true) . "/images/{$entity}/$file";
    }

    /**
     * Делаем изображение круглым
     */
    public static function rounded($fname, $entity) {
        $fpath = Yii::$app->basePath . "/web/images/{$entity}/$fname";
        
        if(!file_exists($fpath)) { return false; }
        list($w, $h) = getimagesize($fpath);
        
        $side_size = $w < $h ? $w : $h;
        
        self::resizeImage($fname, $entity, $side_size, $side_size, true);
        return self::imageCreateRound($fpath);
    }

    public static function imageCreateRound($sourceImageFile) {
        # test source image
        if (file_exists($sourceImageFile)) {
            $res = is_array($info = getimagesize($sourceImageFile));
        } else
            $res = false;

        $file_path = pathinfo($sourceImageFile, PATHINFO_DIRNAME);
        $filename = pathinfo($sourceImageFile, PATHINFO_FILENAME);
        
        # open image
        if ($res) {
            $w = $info[0];
            $h = $info[1];
            switch ($info['mime']) {
                case 'image/jpeg': $src = imagecreatefromjpeg($sourceImageFile);
                    break;
                case 'image/gif': $src = imagecreatefromgif($sourceImageFile);
                    break;
                case 'image/png': $src = imagecreatefrompng($sourceImageFile);
                    break;
                default:
                    $res = false;
            }
        }

        # create corners
        if ($res) {
            $radius = $w / 2;
            
            $q = 1; # change this if you want
            $radius *= $q;

            # find unique color
            do {
                $r = rand(0, 255);
                $g = rand(0, 255);
                $b = rand(0, 255);
            } while (imagecolorexact($src, $r, $g, $b) < 0);
            
            $nw = $w * $q;
            $nh = $h * $q;

            $img = imagecreatetruecolor($nw, $nh);
            $alphacolor = imagecolorallocatealpha($img, $r, $g, $b, 127);
            imagealphablending($img, false);
            imagesavealpha($img, true);
            imagefilledrectangle($img, 0, 0, $nw, $nh, $alphacolor);

            imagefill($img, 0, 0, $alphacolor);
            imagecopyresampled($img, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

            imagearc($img, $radius - 1, $radius - 1, $radius * 2, $radius * 2, 180, 270, $alphacolor);
            imagefilltoborder($img, 0, 0, $alphacolor, $alphacolor);
            imagearc($img, $nw - $radius, $radius - 1, $radius * 2, $radius * 2, 270, 0, $alphacolor);
            imagefilltoborder($img, $nw - 1, 0, $alphacolor, $alphacolor);
            imagearc($img, $radius - 1, $nh - $radius, $radius * 2, $radius * 2, 90, 180, $alphacolor);
            imagefilltoborder($img, 0, $nh - 1, $alphacolor, $alphacolor);
            imagearc($img, $nw - $radius, $nh - $radius, $radius * 2, $radius * 2, 0, 90, $alphacolor);
            imagefilltoborder($img, $nw - 1, $nh - 1, $alphacolor, $alphacolor);
            imagealphablending($img, true);
            imagecolortransparent($img, $alphacolor);

            # resize image down
            $dest = imagecreatetruecolor($w, $h);
            imagealphablending($dest, false);
            imagesavealpha($dest, true);
            imagefilledrectangle($dest, 0, 0, $w, $h, $alphacolor);
            imagecopyresampled($dest, $img, 0, 0, 0, 0, $w, $h, $nw, $nh);

            # output image
            $res = $dest;
            imagedestroy($src);
            imagedestroy($img);
        }
      
        imagepng($res, $file_path . '/' . $filename . '.png');
        
        return $filename . ".png";
    }

    // генерируем имя файла для нового файла
    public static function genFilename($fpath, $ext, $return_with_path = false) {
        $path = Yii::$app->basePath . "/web/images/$fpath/";

        do {
            $name = substr(md5(microtime() . rand(0, 1000)), 0, 8) . ".$ext";
            $filepath = $path . $name;
        } while (file_exists($filepath));

        return $return_with_path ? $filepath : $name;
    }

    public static function removeResizedImages($fname, $entity) {
        $dirs = scandir(Yii::$app->basePath . "/web/images/{$entity}/");

        foreach ($dirs as $d) {
            if ($d == '.' || $d == '..') {
                continue;
            }

            if ($fname && file_exists(Yii::$app->basePath . "/web/images/{$entity}/$d/" . $fname)) {
                unlink(Yii::$app->basePath . "/web/images/{$entity}/$d/" . $fname);
            }
        }
    }

}
