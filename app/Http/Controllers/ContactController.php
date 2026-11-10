<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
            'g-recaptcha-response' => ['required', 'string'],
        ], [
            'g-recaptcha-response.required' => 'Confirma que eres una persona antes de enviar el mensaje.',
        ]);

        if (! config('services.recaptcha.site_key') || ! config('services.recaptcha.secret_key')) {
            return back()->withErrors([
                'captcha' => 'El CAPTCHA todavía no está configurado en el servidor.',
            ])->withInput();
        }

        $verification = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $validated['g-recaptcha-response'],
            'remoteip' => $request->ip(),
        ]);

        if (! $verification->successful() || ! $verification->json('success')) {
            return back()->withErrors([
                'captcha' => 'No pudimos validar el CAPTCHA. Inténtalo nuevamente.',
            ])->withInput();
        }

        Mail::raw(
            "Nombre: {$validated['name']}\nCorreo: {$validated['email']}\n\nMensaje:\n{$validated['message']}",
            function ($mail) use ($validated): void {
                $mail->to(config('mail.contact_recipient'))
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject('Nuevo mensaje desde el sitio web');
            }
        );

        return back()->with('contact_success', 'Tu mensaje fue enviado correctamente.');
    }
}
