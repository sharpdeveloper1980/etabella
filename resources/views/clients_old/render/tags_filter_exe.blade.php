<ul>
@if(count($tags) > 0)
@foreach($tags as $mkey => $tag)
	<li>
		<div class="row">
			<div class="col-md-12">
				<a href="javascript:void(0)" class="tag_row" onclick="getTaggedFiles(<?=$tag->id?>,'{{ $tag->color_tag }}')">
					<i class="fa fa-circle" style="color: {{$tag->color_tag}}"></i>
					<span>{{$tag->title}}</span>
				</a>
			</div>
		</div>
	</li>
@endforeach
@else
	<li></li>
@endif 
</ul>