<?php
namespace App\Transformer;

use App\Models\SocialProject;
use League\Fractal\TransformerAbstract;

Class SocialProjectTransformer extends TransformerAbstract {
       
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(SocialProject $project)
    {
        $images = [];
        $i = 0;
        foreach ($project->images as $image) {
            $images[$i] = array('id' => $image->id, 'url' => url('/').  config('constant.social_project_image_path') .$image->image);
            $i++;
        }
        $f = $project->funded/100;
        $p = $project->pledged/100;
        $a = ceil($f*100/$p);
        return [
            'id' => $project->id,
            'funded' => $project->funded/100,
            'pledged' => $project->pledged/100,
            'backers' => $project->backers,
            'currency' => $project->currency,
            'currency_symbol' => $project->currencySymbol->symbol_left ? $project->currencySymbol->symbol_left: $project->currencySymbol->symbol_right,
            'title' => $project->title,
            'description' => $project->description,
            'long_description' => $project->long_description,
            'logo' => $project->logo,
            'logo_small' => $project->logo_small,
            'images' => $images,
            'remaining_days' => $project->remaining_days,
            'is_completed' => ($f>=$p)?1:0,
            'acheivement' => $a,
            'is_liked' => $project->is_liked
        ];
    }
}
