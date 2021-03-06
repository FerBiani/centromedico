<?php
namespace App\Http\Controllers\Auth;
use App\{Usuario, Nivel, Endereco, Estado, Cidade, Telefone};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;
    public function showRegistrationForm() {
        $estados = Estado::all();
        $cidades = Cidade::all();
        $niveis = Nivel::all();
        return view('auth.register', compact('niveis','estados','cidades'));
    }
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nivel_id' => ['required'],
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Usuario
     */
    protected function create(array $data)
    {
        $usuario = Usuario::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nivel_id' => $data['nivel_id']
        ]);

        Endereco::create([
            'cep' => $data['cep'],
            'logradouro' => $data['logradouro'],
            'bairro' => $data['bairro'],
            'numero' => $data['numero'],
            'complemento' => $data['complemento'],
            'usuario_id' => $usuario->id,
            'cidade_id' => $data['cidade_id'],
        ]);

        Telefone::create([
            'numero' => $data['telefone'],
            'usuario_id' => $usuario->id,
        ]);

        return $usuario;
        
    }
}