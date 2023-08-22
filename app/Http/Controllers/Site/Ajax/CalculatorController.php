<?php namespace App\Http\Controllers\Site\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CalculatorComplex;
use App\Models\CalculatorApartments;

class CalculatorController extends Controller
{

	// == глобальные параметры ===========================================================================================
		protected $years;
		protected $percent; // годовой процент
		protected $months; //180; // период (месяцы)
		protected $living_wage; // 18520; // D21 текущий прожиточный минимум
		protected $insurance; // D28 Коэффициент при страховании жилого помещения
		protected $property_tax; // D30 Ставка налога на имущество, в месяц

		// == глобальные параметры (следствия) ===============================================================================
		protected $_p; // абсолютный ежемесячный процент
		protected $ann; // аннуитет
		// ===================================================================================================================



		public function setData() {

			$this->percent = 10; // годовой процент
			$this->months = $this->years * 12; //180; // период (месяцы)
			$this->living_wage = 31183; //19966; // 18520; // D21 текущий прожиточный минимум
			$this->insurance = 0.0013; // D28 Коэффициент при страховании жилого помещения
			$this->property_tax = 0.015 / 12; // D30 Ставка налога на имущество, в месяц

		// == глобальные параметры (следствия) ===============================================================================
			// $this->_p = $this->percent / 1200; // абсолютный ежемесячный процент
			// $this->ann = $this->_p / (1 - pow(1 + $this->_p, -$this->months)); // аннуитет
		// == глобальные параметры (конец) ===============================================================================

		// == глобальные параметры (новые расчеты) ===============================================================================
			$this->_p = $this->percent * 0.01;
			$this->i = $this->_p / 12;
			$this->f1 = 1 + $this->i;
			$this->f2 = pow($this->f1, $this->years * 12);
			$this->f3 = $this->f2 - 1;
			$this->f4 = $this->i / $this->f3;
			$this->ann = $this->i + $this->f4;
		// == глобальные параметры (новые расчеты) ===============================================================================

		}

		public function getApartments(Request $request) {

			$apartments = CalculatorApartments::where('complexe_id', $request->complex_id)->get();

			if ($apartments) {
				$name = 'name_'.$request->lang;
				$data = [];
				foreach ($apartments as $apartment) {
					$data[] = array(
						'id' => $apartment->id,
						'title' => $apartment->$name,
						'measure' => $apartment->measure,
					);
				}

				return json_encode($data);
			}

		}

		public function getApartmentsCost(Request $request)
		{
			$apartment_cost = CalculatorApartments::findOrFail($request->apartment_id);
			$data = array(
				'id' => $apartment_cost->id,
				'measure' => $apartment_cost->measure,
				'cost' => $apartment_cost->cost_apartments * 1.2
			);

			return json_encode($data);
		}

		public function setYears($tenancy) {
			$this->years = $tenancy;
		}

		public function calculate(Request $request) {
			$data = array();

			$complex = $request->input('complex'); 					// Жилой комлекс
			$apartment = $request->input('apartment'); 				// Площадь квартиры (кв. м)
			$initial_fee = $request->input('initial_fee'); 			// Размер первоначального взноса
			$tenancy = $request->input('tenancy');						// Срок действия Договора аренды с выкупом
			$family = $request->input('family');						// Количество членов семьи Заявителя, которые будут проживать с Заявителем
			$co_applicants = $request->input('co_applicants');			// Количество созаявителей

			$this ->setYears($tenancy);
			$this ->setData();

			$income = array();
			$additional = array();
			$payment = array();

			$prime_cost_q = CalculatorComplex::findOrFail($complex)->cost; // Себестоимость жилья (т/кв. м)
			// доходы заявителя и созаявителей
			if ($co_applicants == 0) {
				$income[0] = $request->input('income')[0];
				$additional[0] = $request->input('additional')[0];
			}else{
				for ($i = 0; $i <= $co_applicants; $i++) {
					$income[$i] = intval($request->input('income')[$i]);
					$additional[$i] = intval($request->input('additional')[$i]);
					if ($income[$i] < 0) $income[$i] = 0;
					if ($additional[$i] < 0) $additional[$i] = 0;
				}
			}

			// prime_cost себестоимость жилья (т)
			$prime_cost = ($apartment * $prime_cost_q) - ($initial_fee / 1.2);

			// rent payment размер ежемесячного арендного платежа (т)
			$rent_payment = $prime_cost * $this->ann;

			// margin сумма гарантийного взноса необходимого для заключения договора аренды с выкупом
			$margin = $rent_payment * 3;

			// insurance Расчет суммы страхования, в месяц
			$insurance = ($prime_cost * $this->insurance) / 12;

			// property_tax Расчет суммы налога на имущество, в месяц
			$property_tax = $prime_cost * $this->property_tax;

			// expenses Ежемесячные расходы по арендуемому помещению
			$expenses = $insurance + $property_tax;

			// total_income совокупные доходы
			$total_income = 0;
			for ($i = 0; $i <= $co_applicants; $i++) {
				$total_income = $total_income + $income[$i] + $additional[$i];
			}

			// living_wage Прожиточный минимум Заявителя,  и членов его (ее) семьи
			$living_wage = ($this->living_wage * $family) + ($this->living_wage * $co_applicants); //FIX добавлен прожиточный минимум созаявителей (бред какой то).

			// total_costs совокупные расходы
			if (empty($payment)) {
				$total_costs = $living_wage + $expenses;
			}else {
				$total_costs = $living_wage + $expenses + $payment[0] + $payment[1] + $payment[2] + $payment[3];
			}

			// msap МСАП
			$msap = $total_income - $total_costs;

			$data['rent_payment'] = number_format(intval($rent_payment), 0, '.', ' ');
			$data['margin'] = number_format(intval($margin), 0, '.', ' ');
			$data['msap'] = number_format(intval($msap), 0, '.', ' ');

			if ($msap - $rent_payment < 0)
				$data['message'] = false;
			else
				$data['message'] = true;
			echo json_encode($data);
		}
}
