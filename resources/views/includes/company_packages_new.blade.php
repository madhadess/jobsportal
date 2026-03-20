<div class="paypackages">
	<!---four-paln-->
	<div class="four-plan">
		<h3>{{__('İş Paketleri')}}</h3>
		<div class="row"> @foreach($packages as $package)
			<div class="col-md-4 col-sm-6 col-xs-12">
				<ul class="boxes">
					<li class="plan-name">{{$package->package_title}}</li>
					<li>
						<div class="main-plan">
							<div class="plan-price1-2">
								{{ $package->package_price == 0 ? 'ÜCRETSİZ' : $package->package_price . ' ₺' }}</div>
							<div class="clearfix"></div>
						</div>
					</li>
					<li class="plan-pages"><i class="far fa-check-square"></i> {{__('İş İlanı')}}
						{{$package->package_num_listings}}
					</li>
					<li class="plan-pages"><i class="far fa-check-square"></i> {{__('İş İlanı Süresi')}}
						{{$package->package_num_days}} {{__('Gün')}}
					</li>
					@if($package->package_price == 10)
						<li class="plan-pages noadded"><i class="far fa-times-circle"></i> {{__('Öne Çıkan İlanlar')}}</li>
					@else
						<li class="plan-pages"><i class="far fa-check-square"></i> {{__('İstek üzerine öne çıkan işler')}}
						</li>

					@endif
					<li class="plan-pages @if($package->package_price == 0) disabled @endif"><i
							class="far fa-check-square"></i> {{__('Premium Destek 24/7')}}</li>

					<li class="order paypal"><a href="javascript:void(0)" data-bs-toggle="modal"
							data-bs-target="#buypack{{$package->id}}" class="reqbtn">{{__('Şimdi Satın Al')}} <i
								class="fas fa-arrow-right"></i></a></li>


				</ul>


				<div class="modal fade" id="buypack{{$package->id}}" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">{{__('Şimdi Satın Al')}}</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"
									aria-label="Close"></button>
							</div>
							<div class="modal-body">

								<div class="invitereval">
									<h3>Lütfen Ödeme Yöntemini Seçin</h3>

									<div class="totalpay">{{__('Ödenecek Toplam Tutar')}}:
										<strong>{{$package->package_price}} ₺</strong>
									</div>

									<ul class="btn2s">
										@if($package->package_price > 0)
											<li class="order paypal p-2"><a
													href="{{route('order.package', $package->id)}}"><i
														class="fas fa-credit-card" aria-hidden="true"></i>
													{{__('Ödeme Yap')}}</a></li>
										@else
											<li class="order paypal p-2"><a
													href="{{route('order.free.package', $package->id)}}">
													{{__('Ücretsiz Pakete Abone Ol')}}</a></li>
										@endif
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
		@endforeach
		</div>
	</div>
	<!---end four-paln-->
</div>