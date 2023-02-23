<?php
class line_flex
{

  public function gen_flex_soth_url($lineid)
  {
    $json_text = '{ "type": "flex", "altText": "lineregistering", "contents": ';
      $json_text .= '{
        "type": "bubble",
        "hero": {
          "type": "image",
          "url": "https://faed.mju.ac.th/soth/images/soth_banner.png",
          "size": "full",
          "aspectMode": "cover",
          "action": {
            "type": "uri",
            "uri": "http://linecorp.com/"
          },
          "aspectRatio": "95:36"
        },
        "footer": {
          "type": "box",
          "layout": "vertical",
          "spacing": "sm",
          "contents": [
            {
              "type": "button",
              "style": "primary",
              "height": "sm",
              "action": {
                "type": "uri",
                "label": "Go to SOTH Application",
                "uri": "https://faed.mju.ac.th/soth/sign/?lineid=' . $lineid . '"
              }
            }
          ],
          "flex": 0,
          "paddingAll": "lg"
        }
      }';
      $json_text .= ' }';
    return $json_text;
  }

  
}
