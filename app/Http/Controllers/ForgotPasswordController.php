<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        // Validação do email
        $request->validate(['email' => 'required|email']);
        // Verificar se o email existe no banco de dados
        $user = User::where('email', $request->email)->first();
        if (!$user) {

            return response()->json(['alerta'  => 'E-mail não encontrado.'], 422);
        }
        // Tentativa de enviar o link de redefinição de senha
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Se o link de redefinição de senha foi enviado com sucesso
        if ($status == Password::RESET_LINK_SENT) {
            // Retorna uma resposta JSON com a mensagem de sucesso e código 200 (OK)
            return response()->json(['message' => __($status)], 200);
        }

        // Lança uma exceção de validação se o envio do link falhar
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function resetPassword(Request $request)
    {
        // Validação dos campos
       // $request->validate([
         //   'token' => 'required',
           // 'email' => 'required|email',
           // 'password' => 'required|min:8|confirmed',
       // ]);

        $rules = [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];

        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        // Tentativa de redefinir a senha
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                // Opcional: Revogar todos os tokens antigos do usuário
                $user->tokens()->delete();

                // Opcional: Criar um novo token para o usuário automaticamente após a redefinição
                $token = $user->createToken('app')->accessToken;

                return response()->json(['token' => $token, 'message' => 'Password reset successful'], 200);
            }
        );

        // Verificação do status e resposta
        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)], 200);
        }

        return response()->json(['message' => __($status)], 400);
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }


}
