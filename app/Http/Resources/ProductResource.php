<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $relatedProducts =[] ;
        foreach ($this->relatedProducts as $item){
            $item->relatedProductt->value = $item->relatedProductt->id;
            $relatedProducts[] = $item->relatedProductt;
        }
        return [
            "id" => (string)$this->id,
            "value" => (string)$this->id,
//            "image" => $this->images[0],
//            "images" => $images,
            "product_category_id" => $this->product_category_id,

            "image" => $this->image,
            "title" => $this->title,
            "title_en" => $this->title_en,
            "subTitle" => $this->subTitle,
            "flavor" => $this->flavor,
            "flavor_en" => $this->flavor_en,
//            "tag1" => $this->tag1,
//            "tag2" => $this->tag2,
//            "color" => $this->color,
            "link" => $this->link,

            "stock" => $this->stock,
            "active" => (boolean)$this->active,
            "text" => $this->text,
            "category" => [
                'id' => $this->category->id,
                'title' => $this->category->title,
                'active' => $this->category->active,
            ],
            "related_products" => $relatedProducts,

//            "sizes" => $this->sizes,


            "features" => $this->features,
            "price" => $this->price,
            "off" => $this->off,
            "view" => $this->view,
            "score" => $this->score,
            "score_count" => $this->score_count,
//            "views" => $this->views,
//            "likes" => $this->likes,
//            "dislikes" => $this->dislikes,
            "created_at" => date('Y-m-d', strtotime($this->created_at)),
            "updated_at" => date('Y-m-d', strtotime($this->updated_at)),
        ];
    }
}
