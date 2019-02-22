<?php


namespace app\models;


class Helper
{
    public function getLetterByNum()
    {
        $arr = [
            1 => 'a',
            2 => 'b',
            3 => 'c',
            4 => 'd',
            5 => 'e',
            6 => 'f',
            7 => 'g',
            8 => 'h',
            9 => 'i',
            10 => 'j',
            11 => 'k',
            12 => 'l',
            13 => 'm',
            14 => 'n',
            15 => 'o',
            16 => 'p',
            17 => 'q',
            18 => 'r',
            19 => 's',
            20 => 't',
            21 => 'u',
            22 => 'v',
            23 => 'w',
            24 => 'x',
            25 => 'y',
            26 => 'z',
        ];

        return $arr;
    }

    public function getLetter($name)
    {
        switch ($name) {
            case 'a':
                return 1;
                break;
            case 'b':
                return 2;
                break;
            case 'c':
                return 3;
                break;
            case 'd':
                return 4;
                break;
            case 'e':
                return 5;
                break;
            case 'f':
                return 6;
                break;
            case 'g':
                return 7;
                break;
            case 'h':
                return 8;
                break;
            case 'i':
                return 9;
                break;
            case 'j':
                return 10;
                break;
            case 'k':
                return 11;
                break;
            case 'l':
                return 12;
                break;
            case 'm':
                return 13;
                break;
            case 'n':
                return 14;
                break;
            case 'o':
                return 15;
                break;
            case 'p':
                return 16;
                break;
            case 'q':
                return 17;
                break;
            case 'r':
                return 18;
                break;
            case 's':
                return 19;
                break;
            case 't':
                return 20;
                break;
            case 'u':
                return 21;
                break;
            case 'v':
                return 22;
                break;
            case 'w':
                return 23;
                break;
            case 'x':
                return 24;
                break;
            case 'y':
                return 25;
                break;
            case 'z':
                return 26;
        }
    }
}