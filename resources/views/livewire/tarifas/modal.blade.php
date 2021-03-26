<div class="modal fade" id="modalTarifa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> Descrição do Veiculo</h5>
			</div>
			<div class="modal-body">
				<div class="widget-content-area">
					<div class="widget-one">
						<form>			
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-sm-12">
									<label >Tempo</label>
									<select id="time" class="form-control text-center temposelect">
										<option value="Selecione">Selecione</option>
										{{-- <option value="Fração">Fração</option> --}}
										<option value="Hora">Hora</option>
										<option value="Diária">Diária</option>
										<option value="Semanal">Semanal</option>
										<option value="Mensal">Mensal</option>										
									</select>
									 @error('time') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
								<div class="form-group col-lg-4 col-md-4 col-sm-12">
									<label >Tipo</label>
									<select id="type_id" class="form-control text-center">
										<option value="Selecione" disabled="">Selecione</option>
										@foreach($types as $t)
										<option value="{{ $t->id }}" >
											{{ $t->description}}
										</option>
										@endforeach
									</select>
									 @error('type') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
								
								<div class="form-group col-lg-4 col-md-4 col-sm-12">
									<label >Valor</label>
									<input id="amount" type="number" class="form-control text-center numeric">
									 @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
								<div class="form-group col-lg-8 col-sm-12 mb-8">
									<label >Descrição</label>
									<input id="description" type="text" class="form-control"  placeholder="Tarifa Hora Coche">
									 @error('description') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
								<div class="form-group col-lg-4 col-md-4 col-sm-12">
									<label >Hierarquia</label>
									<input id="hierarchy" type="text" class="form-control text-center" disabled value="{{$hierarchy}}">
									 @error('hierarchy') <span class="text-danger">{{ $message }}</span> @enderror
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"> Cancelar </i></button>
				<button type="button" onclick="save()" class="btn btn-success saveTarifa"> Salvar </button>	
			</div>
		</div>
	</div>
</div>