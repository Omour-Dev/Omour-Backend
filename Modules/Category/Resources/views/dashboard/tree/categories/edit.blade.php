@foreach ($mainCategories as $cat)
	@if ($category->id != $cat->id)
		<ul>
			<li id="{{$cat->id}}" data-jstree='{"opened":true @if ($category->category_id == $cat->id),"selected":true @endif }'>
				{{$cat->translate(locale())->title}}
				@if($cat->children->count() > 0)
					@include('category::dashboard.tree.categories.edit',['mainCategories' => $cat->children])
				@endif
			</li>
		</ul>
	@endif
@endforeach
