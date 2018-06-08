<?php
namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use Intervention\Image\ImageManagerStatic;

/**
 * Description of Base64FileSaveBehavior
 *
 * @author Sergiy Filonyuk
 */
class Base64FileSaveBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'saveImage'
        ];
    }

    public function saveImage()
    {
        if (empty($this->owner->image)) {
            return;
        }
        $fileName = uniqid() . '.png';
        $filePath = Yii::getAlias('@frontend/web/images/uploads/') . $fileName;
        $thumbPath = Yii::getAlias('@frontend/web/images/uploads/thumbnail_') . $fileName;
        
        $file = ImageManagerStatic::make($this->owner->image);
        file_put_contents($filePath, $file->encode());
        
        $this->owner->image = '/images/uploads/'.$fileName;
        $this->owner->image_thumbnail = '/images/uploads/thumbnail_'.$fileName;
        $this->createThumbnail($filePath, $thumbPath);        
    }

    private function createThumbnail(string $original, string $thumbnail)
    {
        copy($original, $thumbnail);
        $file = ImageManagerStatic::make($thumbnail)->fit(64, 64);
        file_put_contents($thumbnail, $file->encode());
        
    }

    private function base64_to_jpeg($base64_string, $output_file)
    {
        // open the output file for writing
        $ifp = fopen($output_file, 'wb');

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode(',', $base64_string);

        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($data[1]));

        // clean up the file resource
        fclose($ifp);

        return $output_file;
    }
}
