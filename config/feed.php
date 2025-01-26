<?php

return [
    'feeds' => [
        'news' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * [App\Model::class, 'getAllFeedItems']
             */
            'items' => [\App\Models\News::class, 'getFeedItems'],

            /*
             * The feed will be available on this url.
             */
            'url' => 'feed',

            'title' => 'آخر الأخبار',
            'description' => 'آخر وأهم الأخبار من موقعنا',
            'language' => 'ar',

            /*
             * The format of the feed. Acceptable values are 'rss', 'atom', or 'json'.
             */
            'format' => 'json',

            /*
             * The type to be used in the <link> tag
             */
            'type' => 'application/json',
            
            /*
             * The base URL for all relative links in the feed
             */
            'link' => config('app.url'),
        ],
    ],
];
