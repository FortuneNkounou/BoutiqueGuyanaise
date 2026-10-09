<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Aucun compte associé à cet email.',
        ]);

        // on supprime l'ancien token s'il existe
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $url = route('password.reset', ['token' => $token, 'email' => $request->email]);

        try {
            Mail::send('emails.reset-password', ['url' => $url], function ($msg) use ($request) {
                $msg->to($request->email)->subject('Réinitialisation de mot de passe - Boutique Guyanaise');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Impossible d\'envoyer l\'email. Vérifiez votre connexion ou réessayez plus tard.']);
        }

        return back()->with('success', 'Un lien de réinitialisation a été envoyé.');
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Lien invalide ou expiré.']);
        }

        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['token' => 'Ce lien a expiré, demandez-en un nouveau.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Mot de passe modifié, vous pouvez vous connecter.');
    }
}
