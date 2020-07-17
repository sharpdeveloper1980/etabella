<ul>
@if(count($tags) > 0)
@foreach($tags as $mkey => $tag)
	<li>
		<div class="row">
			<div class="col-md-8">
				<a href="#" class="tag_row" onclick="tagRow(<?=$tag->id?>)">
					<i class="fa fa-circle" style="color: {{$tag->color_tag}}"></i>
					<span>{{$tag->title}}</span>
				</a>
			</div>
			<div class="col-md-2">
				<a href="#" onclick="deleteTag(<?=$tag->id?>)"><i class="fa fa-trash"></i></a>
			</div>
		</div>
	</li>
@endforeach
@else
	<li></li>
@endif 
</ul>