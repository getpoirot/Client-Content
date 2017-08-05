# Client-Content
Http Client For Content Posts Module.

# Create New Post With Related Content Image File
 
```php
# Upload File To O-Storage
#
$uploadedFile = \Apanaj\IOC::ClientTenderBin()
    ->store(
        fopen(__DIR__.'/files/infinie.jpeg', 'r')
        , null
        , 'Infinite'
        , []
        , time() + (5 * 60) // file available just for 5 minute
    );

# Insert New Post
#
$r = \Apanaj\IOC::ClientContent()
    ->create(new PostContentObject([
        'content_type' => 'general',
        'content'      => [
            "description" => "any text content #with_hash_tag or @mention that will extracted.",
            'medias' => [
                [ 'hash' => $uploadedFile['bindata']['hash']
                    , 'content_type' => $uploadedFile['bindata']['content_type'] ],
            ],
        ],
    ]));
```
