@foreach ($mainCategories as $category)
<ul>
		<li id="{{$category->id}}" data-jstree='{"opened":true}'>
				{{$category->translate(locale())->title}}
				@if($category->children->count() > 0)
						@include('product::dashboard.tree.products.view',['mainCategories' => $category->children])
				@endif
		</li>
</ul>
@endforeach
