<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = [
            'company_name' => setting('company_name', 'PT. Kharisma Sukses Persada'),
            'company_address' => setting('company_address', ''),
            'company_phone' => setting('company_phone', ''),
            'company_email' => setting('company_email', ''),
            'company_logo' => setting('company_logo', ''),
            'tax_rate' => setting('tax_rate', 11),
            'currency' => setting('currency', 'IDR'),
            'date_format' => setting('date_format', 'd/m/Y'),
            'time_format' => setting('time_format', 'H:i'),
            'timezone' => setting('timezone', 'Asia/Jakarta'),
            'email_notifications_enabled' => setting('email_notifications_enabled', true),
            'sms_notifications_enabled' => setting('sms_notifications_enabled', false),
            'low_stock_threshold' => setting('low_stock_threshold', 10),
            'payment_due_days' => setting('payment_due_days', 30),
        ];

        return view('settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_logo' => 'nullable|string|max:255',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|max:10',
            'date_format' => 'required|string|max:20',
            'time_format' => 'required|string|max:20',
            'timezone' => 'required|string|max:50',
            'email_notifications_enabled' => 'boolean',
            'sms_notifications_enabled' => 'boolean',
            'low_stock_threshold' => 'required|integer|min:0',
            'payment_due_days' => 'required|integer|min:1',
        ]);

        foreach ($validated as $key => $value) {
            setting([$key => $value]);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Reset settings to default.
     */
    public function reset()
    {
        $defaultSettings = [
            'company_name' => 'PT. Kharisma Sukses Persada',
            'company_address' => '',
            'company_phone' => '',
            'company_email' => '',
            'company_logo' => '',
            'tax_rate' => 11,
            'currency' => 'IDR',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'timezone' => 'Asia/Jakarta',
            'email_notifications_enabled' => true,
            'sms_notifications_enabled' => false,
            'low_stock_threshold' => 10,
            'payment_due_days' => 30,
        ];

        foreach ($defaultSettings as $key => $value) {
            setting([$key => $value]);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil direset ke default.');
    }
}
