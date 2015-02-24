			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<h2>Include Dates</h2>
					<table class="table" id="days-include">
						<thead>
							<tr>
								<th>From</th>
								<th>To</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr class="template">
								<td><input type="date" class="form-control begin" name="days[include][begin][]"/></td>
								<td><input type="date" class="form-control end"   name="days[include][end][]"/></td>
								<td><button class="btn btn-danger" onclick="removeRange(this)">x</button></td>
							</tr>
							<tr>
								<td><button class="add btn btn-success">Add</button></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
					
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<h2>Exclude Dates</h2>
					<table class="table" id="days-exclude">
						<thead>
							<tr>
								<th>From</th>
								<th>To</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr class="template">
								<td><input type="date" class="form-control begin" name="days[exclude][begin][]" /></td>
								<td><input type="date" class="form-control end"   name="days[exclude][end][]"/></td>
								<td><button class="btn btn-danger" onclick="removeRange(this);">x</button></td>
							</tr>
							<tr>
								<td><button class="add btn btn-success">Add</button></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<h2>Include Hours</h2>
					<table class="table" id="hours-include">
						<thead>
							<tr>
								<th>From</th>
								<th>To</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr class="template">
								<td>
									<select name="hours[include][begin][]" class="form-control">
										<option value="" selected="selected" disabled="disabled"></option>
										<option value="0">12 AM</option>
										<option value="1">1 AM</option>
										<option value="2">2 AM</option>
										<option value="3">3 AM</option>
										<option value="4">4 AM</option>
										<option value="5">5 AM</option>
										<option value="6">6 AM</option>
										<option value="7">7 AM</option>
										<option value="8">8 AM</option>
										<option value="9">9 AM</option>
										<option value="10">10 AM</option>
										<option value="11">11 AM</option>
										<option value="12">12 PM</option>
										<option value="13">1 PM</option>
										<option value="14">2 PM</option>
										<option value="15">3 PM</option>
										<option value="16">4 PM</option>
										<option value="17">5 PM</option>
										<option value="18">6 PM</option>
										<option value="19">7 PM</option>
										<option value="20">8 PM</option>
										<option value="21">9 PM</option>
										<option value="22">10 PM</option>
										<option value="23">11 PM</option>
									</select>
								</td>
								<td>
									<select name="hours[include][end][]" class="form-control">
										<option value="" selected="selected" disabled="disabled"></option>
										<option value="0">12 AM</option>
										<option value="1">1 AM</option>
										<option value="2">2 AM</option>
										<option value="3">3 AM</option>
										<option value="4">4 AM</option>
										<option value="5">5 AM</option>
										<option value="6">6 AM</option>
										<option value="7">7 AM</option>
										<option value="8">8 AM</option>
										<option value="9">9 AM</option>
										<option value="10">10 AM</option>
										<option value="11">11 AM</option>
										<option value="12">12 PM</option>
										<option value="13">1 PM</option>
										<option value="14">2 PM</option>
										<option value="15">3 PM</option>
										<option value="16">4 PM</option>
										<option value="17">5 PM</option>
										<option value="18">6 PM</option>
										<option value="19">7 PM</option>
										<option value="20">8 PM</option>
										<option value="21">9 PM</option>
										<option value="22">10 PM</option>
										<option value="23">11 PM</option>
									</select>
								</td>
								<td>
									<button class="btn btn-danger" onclick="removeRange(this)">x</button>
								</td>
							</tr>
							<tr>
								<td><button class="add btn btn-success">Add</button></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<h2>Exclude Hours</h2>
					<table class="table" id="hours-exclude">
						<thead>
							<tr>
								<th>From</th>
								<th>To</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr class="template">
								<td>
									<select name="exclude[hours][begin][]" class="form-control">
										<option value="" selected="selected" disabled="disabled"></option>
										<option value="0">12 AM</option>
										<option value="1">1 AM</option>
										<option value="2">2 AM</option>
										<option value="3">3 AM</option>
										<option value="4">4 AM</option>
										<option value="5">5 AM</option>
										<option value="6">6 AM</option>
										<option value="7">7 AM</option>
										<option value="8">8 AM</option>
										<option value="9">9 AM</option>
										<option value="10">10 AM</option>
										<option value="11">11 AM</option>
										<option value="12">12 PM</option>
										<option value="13">1 PM</option>
										<option value="14">2 PM</option>
										<option value="15">3 PM</option>
										<option value="16">4 PM</option>
										<option value="17">5 PM</option>
										<option value="18">6 PM</option>
										<option value="19">7 PM</option>
										<option value="20">8 PM</option>
										<option value="21">9 PM</option>
										<option value="22">10 PM</option>
										<option value="23">11 PM</option>
									</select>
								</td>
								<td>
									<select name="exclude[hours][end][]" class="form-control">
										<option value="" selected="selected" disabled="disabled"></option>
										<option value="0">12 AM</option>
										<option value="1">1 AM</option>
										<option value="2">2 AM</option>
										<option value="3">3 AM</option>
										<option value="4">4 AM</option>
										<option value="5">5 AM</option>
										<option value="6">6 AM</option>
										<option value="7">7 AM</option>
										<option value="8">8 AM</option>
										<option value="9">9 AM</option>
										<option value="10">10 AM</option>
										<option value="11">11 AM</option>
										<option value="12">12 PM</option>
										<option value="13">1 PM</option>
										<option value="14">2 PM</option>
										<option value="15">3 PM</option>
										<option value="16">4 PM</option>
										<option value="17">5 PM</option>
										<option value="18">6 PM</option>
										<option value="19">7 PM</option>
										<option value="20">8 PM</option>
										<option value="21">9 PM</option>
										<option value="22">10 PM</option>
										<option value="23">11 PM</option>
									</select>
								</td>
								<td><button class="btn btn-danger" onclick="removeRange(this);">x</button></td>
							</tr>
							<tr>
								<td><button class="add btn btn-success">Add</button></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>	
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<h2>Filter Data</h2>

					<button type="submit" class="add btn btn-info" onclick="drawChart(true);">Filter</button>
				</div>
			</div>