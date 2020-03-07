<?php
/**
 *
 *
 */
require ("./dict/dict_array.php");

class Recognition
{

    /**
     * @var string|null 返回结果
     */
    protected $code = null;

    /**
     * @var array 整体处理
     */
    protected $image = array();

    /**
     * @var array 分离字符
     */
    protected $list = array();

    /**
     * @var string|null 入典
     */
    protected $libraryFirst;
    protected $librarySecond;
    protected $libraryThird;
    protected $libraryForth;

    /**
     * @var integer 首字像素范围
     */
    protected $Fstart,$Flength;

    /**
     * @var integer 第二个字像素范围
     */
    protected $Sstart,$Slength;

    /**
     * @var integer 第三个像素范围
     */
    protected $Tstart,$Tlength;

    /**
     * @var integer 第四个像素范围
     */
    protected $FOstart,$FOlength;

    /**
     * @var integer 颜色的rbg
     */
    protected $rbg;

    public function __construct($data=[],$rbg=100)
    {

        // set side
        $this -> Fstart = $data[0][0];
        $this -> Flength = $data[0][1];
        $this -> Sstart = $data[1][0];
        $this -> Slength = $data[1][1];
        $this -> Tstart = $data[2][0];
        $this -> Tlength = $data[2][1];
        $this -> FOstart = $data[3][0];
        $this -> FOlength = $data[3][1];
        //set rbg
        $this -> rbg = $rbg;

        //        $this->run();

    }

    /**
     * @return string|null start
     */
    protected function run ()
    {

        $this -> amazing('yzm.jpg');
        $this -> splitImage();

        for ($i=0; $i<=3; $i++) {
            $this -> library($this->list[$i],$i);
            $match = $this -> match($i);
            $this -> code .= $match['key'];
        }

//        foreach ($library as $item) {
//            foreach ($item as $code) {
//                print_r($code);
//            }
//        }

        return $this -> code;

    }

    /**
     * @param array $list   After split
     */
    protected function library ($list,$num)
    {

        foreach ($list as $row) {
            foreach ($row as $column) {
                if ($num==0) {$this ->libraryFirst .= $column;}
                if ($num==1) {$this ->librarySecond .= $column;}
                if ($num==2) {$this ->libraryThird .= $column;}
                if ($num==3) {$this ->libraryForth .= $column;}
            }
        }

    }

// 匹配

    /**
     * @param string $verify   dict
     * @param integer $num    num
     * @return array
     */
    protected function match ($num)
    {
        global $libraryFirst;
        global $librarySecond;
        global $libraryThird;
        global $libraryFour;

        $match = array('per' => '', 'key' => '');

        if ($num == 0) {

            foreach ($libraryFirst as $item) {
                foreach ($item as $key => $value) {
                    $percent = 0.0;
                    similar_text($this->libraryFirst, $value, $percent);   //计算两个字符串的相似度，并返回匹配字符的数目

                    if($match['per'] == '') {
                        $match['per'] = $percent;
                        $match['key'] = $key;
                    } else {
                        if($percent > $match['per'] ) {
                            $match['per'] = $percent;
                            $match['key'] = $key;
                        }
                    }
                }
            }


            return $match;

        } else if ($num == 1){

            foreach ($librarySecond as $item) {
                foreach ($item as $key => $value) {
                    $percent = 0.0;
                    similar_text($this->librarySecond, $value, $percent);

                    if($match['per'] == '') {
                        $match['per'] = $percent;
                        $match['key'] = $key;
                    } else {
                        if($percent > $match['per']) {
                            $match['per'] = $percent;
                            $match['key'] = $key;
                        }
                    }
                }
            }


            return $match;

        } else if ($num == 2){

            foreach ($libraryThird as $item){
                foreach ($item as $key => $value) {
                    $percent = 0.0;
                    similar_text($this->libraryThird, $value, $percent);

                    if($match['per'] == '') {
                        $match['per'] = $percent;
                        $match['key'] = $key;
                    } else {
                        if($percent > $match['per']) {
                            $match['per'] = $percent;
                            $match['key'] = $key;
                        }
                    }
                }
            }


            return $match;
        } else if ($num == 3) {

            foreach ($libraryFour as $item) {
                foreach ($item as $key => $value) {
                    $percent = 0.0;
                    similar_text($this->libraryForth, $value, $percent);

                    if($match['per'] == '') {
                        $match['per'] = $percent;
                        $match['key'] = $key;
                    } else {
                        if($percent > $match['per']) {
                            $match['per'] = $percent;
                            $match['key'] = $key;
                        }
                    }
                }
            }


            return $match;
        }
    }

    /**
     * @param array $getImage    Before spilt
     * @param integer $start    start px
     * @param integer $length   length
     * @return mixed
     */
    protected function extractWord ($getImage,$start,$length)
    {
        // pick up
        foreach ($getImage as $key => $value) {
            for ($i=0; $i<=$start; $i++) {
                unset($getImage[$key][$i]);
            }
            for ($i=139; $i>=$length; $i--) {
                unset($getImage[$key][$i]);
            }

        }

        return $getImage;
    }

    /**
     *  split the Image
     */
    protected function splitImage ()
    {

//        for ($i=0; $i<count($this -> image); $i++) {
//            if ($i<=10) {
//                unset($this -> image[$i]);
//                array_pop($this -> image);
//            }
//        }

        // 上下切割
        for ($i=0;$i<18;$i++) {
            unset($this -> image[$i]);
        }
        for ($i=60;$i>45;$i--) {
            unset($this -> image[$i]);
        }


        $first = $this -> extractWord($this -> image,$this->Fstart,$this->Flength);
        $second = $this -> extractWord($this -> image,$this->Sstart,$this->Slength);
        $third = $this -> extractWord($this -> image,$this->Tstart,$this->Tlength);
        $four = $this -> extractWord($this -> image,$this->FOstart,$this->FOlength);

        $this->list[] = $first;
        $this->list[] = $second;
        $this->list[] = $third;
        $this->list[] = $four;

    }

    /**
     * @param string $filename  Just filename
     */
    protected function amazing ($filename)
    {
        $im = imagecreatefromjpeg('./image/'.$filename);
        list($width,$height) = getimagesize('./image/'.$filename);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($im, $x, $y);
                $rgb = imagecolorsforindex($im, $rgb);
                if ($rgb['red'] <= $this -> rbg && $rgb['green'] <= $this -> rbg && $rgb['blue'] <= $this -> rbg) {
                    $this -> image[$y][$x] = 1;
                } else {
                    $this -> image[$y][$x] = 0;
                }
            }
        }

    }

}
//[Fstart,Flength],[Sstart,Slength],[Tstart,Tlength],[FOstart,FOlength]