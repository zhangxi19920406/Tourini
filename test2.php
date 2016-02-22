<?php

/*
 * ����˵��
 * $max_file_size : �ϴ��ļ���С����, ��λBYTE
 * $destination_folder : �ϴ��ļ�·��
 * $watermark : �Ƿ񸽼�ˮӡ(1Ϊ��ˮӡ,����Ϊ����ˮӡ);
 *
 * ʹ��˵��:
 * 1. ��PHP.INI�ļ������"extension=php_gd2.dll"һ��ǰ���;��ȥ��,��Ϊ����Ҫ�õ�GD��;
 * 2. ��extension_dir =��Ϊ���php_gd2.dll����Ŀ¼;
 */

// �ϴ��ļ������б�

$uptypes = array (
    'image/jpg',
    'image/png',
    'image/jpeg',
    'image/pjpeg',
    'image/gif',
    'image/bmp',
    'image/x-png'
);

$max_file_size = 20000000;                 //�ϴ��ļ���С���ƣ���λBYTE

$destination_folder = 'upload/';     //�ϴ��ļ�·��

$watermark = 1;                         //�Ƿ񸽼�ˮӡ(1Ϊ��ˮӡ,����Ϊ����ˮӡ);

$watertype = 1;                         //ˮӡ����(1Ϊ����,2ΪͼƬ)

$waterposition = 1;                     //ˮӡλ��(1Ϊ���½�,2Ϊ���½�,3Ϊ���Ͻ�,4Ϊ���Ͻ�,5Ϊ����);

$waterstring = "http://www.xplore.cn/"; //ˮӡ�ַ���

$waterimg = "xplore.gif";                //ˮӡͼƬ

$imgpreview = 1;                         //�Ƿ�����Ԥ��ͼ(1Ϊ����,����Ϊ������);

$imgpreviewsize = 1 / 2;                 //����ͼ����

?>
<html>
<head>
<title>ZwelLͼƬ�ϴ�����</title>
</head>
<body>
<form id="upfile" name="upform" enctype="multipart/form-data" method="post" action="">
  <label for="upfile">UP LOAD FILE:</label>
  <input type="file" name="upfile" id="fileField" />
  <input type="submit" name="submit" value="-upload-"/>

</form>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //�ж��Ƿ����ϴ��ļ�

    if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
        $upfile = $_FILES['upfile'];
        print_r($_FILES['upfile']);

        $name = $upfile['name'];             //�ļ���

        $type = $upfile['type'];             //�ļ�����

        $size = $upfile['size'];             //�ļ���С

        $tmp_name = $upfile['tmp_name'];     //��ʱ�ļ�

        $error = $upfile['error'];         //����ԭ��


        if ($max_file_size < $size) {        //�ж��ļ��Ĵ�С

            echo '�ϴ��ļ�̫��';
            exit ();
        }

        if (!in_arrar($type, $uptypes)) {        //�ж��ļ�������

            echo '�ϴ��ļ����Ͳ���' . $type;
            exit ();
        }

        if (!file_exists($destination_folder)) {
            mkdir($destination_folder);
        }

        if (file_exists("upload/" . $_FILES["file"]["name"])) {
            echo $_FILES["file"]["name"] . " already exists. ";
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
            echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
        }

        $pinfo = pathinfo($name);
        $ftype = $pinfo['extension'];
        $destination = $destination_folder . time() . "." . $ftype;
        if (file_exists($destination) && $overwrite != true) {
            echo "ͬ�����ļ��Ѿ�������";
            exit ();
        }

        if (!move_uploaded_file($tmp_name, $destination)) {
            echo "�ƶ��ļ�����";
            exit ();
        }

        $pinfo = pathinfo($destination);
        $fname = $pinfo[basename];
        echo " <font color=red>�Ѿ��ɹ��ϴ�</font><br>�ļ���: <font color=blue>" . $destination_folder . $fname . "</font><br>";
        echo " ���:" . $image_size[0];
        echo " ����:" . $image_size[1];
        echo "<br> ��С:" . $file["size"] . " bytes";

        if ($watermark == 1) {
            $iinfo = getimagesize($destination, $iinfo);
            $nimage = imagecreatetruecolor($image_size[0], $image_size[1]);
            $white = imagecolorallocate($nimage, 255, 255, 255);
            $black = imagecolorallocate($nimage, 0, 0, 0);
            $red = imagecolorallocate($nimage, 255, 0, 0);
            imagefill($nimage, 0, 0, $white);
            switch ($iinfo[2]) {
                case 1 :
                    $simage = imagecreatefromgif($destination);
                    break;
                case 2 :
                    $simage = imagecreatefromjpeg($destination);
                    break;
                case 3 :
                    $simage = imagecreatefrompng($destination);
                    break;
                case 6 :
                    $simage = imagecreatefromwbmp($destination);
                    break;
                default :
                    die("��֧�ֵ��ļ�����");
                    exit;
            }

            imagecopy($nimage, $simage, 0, 0, 0, 0, $image_size[0], $image_size[1]);
            imagefilledrectangle($nimage, 1, $image_size[1] - 15, 80, $image_size[1], $white);

            switch ($watertype) {
                case 1 : //��ˮӡ�ַ���

                    imagestring($nimage, 2, 3, $image_size[1] - 15, $waterstring, $black);
                    break;
                case 2 : //��ˮӡͼƬ

                    $simage1 = imagecreatefromgif("xplore.gif");
                    imagecopy($nimage, $simage1, 0, 0, 0, 0, 85, 15);
                    imagedestroy($simage1);
                    break;
            }

            switch ($iinfo[2]) {
                case 1 :
                    //imagegif($nimage, $destination);

                    imagejpeg($nimage, $destination);
                    break;
                case 2 :
                    imagejpeg($nimage, $destination);
                    break;
                case 3 :
                    imagepng($nimage, $destination);
                    break;
                case 6 :
                    imagewbmp($nimage, $destination);
                    //imagejpeg($nimage, $destination);

                    break;
            }

            //����ԭ�ϴ��ļ�

            imagedestroy($nimage);
            imagedestroy($simage);

        }

        if ($imgpreview == 1) {
            echo "<br>ͼƬԤ��:<br>";
            echo "<img src=\"" . $destination . "\" width=" . ($image_size[0] * $imgpreviewsize) . " height=" . ($image_size[1] * $imgpreviewsize);
            echo " alt=\"ͼƬԤ��:\r�ļ���:" . $destination . "\r�ϴ�ʱ��:\">";
        }

    }

}
?>
</body>
</html>