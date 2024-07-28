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
        if($this->relatedProducts){
            foreach ($this->relatedProducts as $item){
                $item->relatedProductt->value = $item->relatedProductt->id;
                $thumb2 = $item->relatedProductt->image ? str_replace('.png','_thumb.png', $item->relatedProductt->image) : '';
                $item->relatedProductt->thumb = $thumb2;
                $relatedProducts[] = $item->relatedProductt;
            }
        }
        $thumb = $this->image ? str_replace('.png','_thumb.png', $this->image) : '';
        return [
            "id" => (string)$this->id,
            "value" => (string)$this->id,
            "index" => $this->index,
            "product_category_id" => $this->product_category_id,
            "image" => $this->image,
            "thumb" => $thumb,
            "title" => $this->title,
            "title_en" => $this->title_en,
            "title_ar" => $this->title_ar,
            "subTitle" => $this->subTitle,
            "flavor" => $this->flavor,
            "flavor_en" => $this->flavor_en,
            "flavor_ar" => $this->flavor_ar,
            "ingredients" => $this->ingredients,
            "ingredients_en" => $this->ingredients_en,
            "ingredients_ar" => $this->ingredients_ar,
            "link" => $this->link,
            "stock" => $this->stock,
            "active" => (boolean)$this->active,
            "text" => $this->text,
            "text_en" => $this->text_en,
            "text_ar" => $this->text_ar,
            "category" => [
                'id' => $this->category->id,
                'title' => $this->category->title,
                'title_en' => $this->category->title_en,
                'title_ar' => $this->category->title_ar,
                'active' => $this->category->active,
                "subCategories" => $this->category->subCategories,
            ],
            "related_products" => $relatedProducts,
            "color" => $this->color,
            "features" => $this->features,
            "features_en" => $this->features_en,
            "features_ar" => $this->features_ar,
            "price" => $this->price,
            "off" => $this->off,
            "view" => $this->view,
            "score" => $this->score,
            "score_count" => $this->score_count,
            "created_at" => date('Y-m-d', strtotime($this->created_at)),
            "updated_at" => date('Y-m-d', strtotime($this->updated_at)),
        ];
    }
}
