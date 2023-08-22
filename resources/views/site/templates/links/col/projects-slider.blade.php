@if (count($links) > 0)
	<section class="section s-projects">
		{{-- <div class="container">
			<h2 class="title-section">{{ $section->name }}</h2>
		</div><!-- /.container --> --}}

		<div class="projects-slider slick-slider lightgallery js-projects-slider">
			@foreach ($links as $link)
				<div>
					<a class="projects-slider__slide" href="/{{ $link->photo }}" data-rel="lightgallery">
						<div class="projects-slider__img"
								 style="background-image: url('/image/resize/634/422/{{ $link->photo }}');"></div>
					</a>
				</div>
			@endforeach
		</div><!-- /.projects-slider -->
	</section>
@endif
