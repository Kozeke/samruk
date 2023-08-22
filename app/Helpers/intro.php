<?php

if (!function_exists('getIntroImage')) {
    function getIntroImage ()
    {
        $imagePath = '/site/img/intro/bg/22-00.jpg';
        $date = new DateTime(date('Y') . '-' . date('m') . '-' . date('d'));
        $currentTime = time();
        $images = [
            [
                'path' => '/site/img/intro/bg/04-30.jpg',
                'start' => $date->setTime(4, 30)->format('U'),
                'end' => $date->setTime(5, 30)->format('U')
            ],
            [
                'path' => '/site/img/intro/bg/05-30.jpg',
                'start' => $date->setTime(5, 30)->format('U'),
                'end' => $date->setTime(6, 30)->format('U')
            ],
            [
                'path' => '/site/img/intro/bg/06-30.jpg',
                'start' => $date->setTime(6, 30)->format('U'),
                'end' => $date->setTime(8, 0)->format('U')
            ],
            [
                'path' => '/site/img/intro/bg/08-00.jpg',
                'start' => $date->setTime(8, 0)->format('U'),
                'end' => $date->setTime(10, 0)->format('U')
            ],
            [
                'path' => '/site/img/intro/bg/10-00.jpg',
                'start' => $date->setTime(10, 0)->format('U'),
                'end' => $date->setTime(12, 0)->format('U')
            ],
            [
                'path' => '/site/img/intro/bg/12-00.jpg',
                'start' => $date->setTime(12, 0)->format('U'),
                'end' => $date->setTime(17, 0)->format('U')
            ],
            [
                'path' => '/site/img/intro/bg/17-00.jpg',
                'start' => $date->setTime(17, 0)->format('U'),
                'end' => $date->setTime(19, 0)->format('U')
            ],
            [
                'path' => '/site/img/intro/bg/19-00.jpg',
                'start' => $date->setTime(19, 0)->format('U'),
                'end' => $date->setTime(20, 0)->format('U')
            ],
            [
                'path' => '/site/img/intro/bg/20-00.jpg',
                'start' => $date->setTime(20, 0)->format('U'),
                'end' => $date->setTime(22, 0)->format('U')
            ]
        ];

        foreach ($images as $image) {
            if ($currentTime >= $image['start'] && $currentTime <= $image['end']) {
                $imagePath = $image['path'];
            }
        }

        return $imagePath;
    }
}
