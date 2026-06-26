<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\NotificationModel;
use App\Mail\RegisterMail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Admin login page
    public function login_admin()
    {
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return redirect('admin/dashboard');
        }

        return view('admin.auth.login');
    }

    // Handle admin login
    public function auth_login_admin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => 1,
            'status' => 0,
            'is_delete' => 0
        ], $remember)) {
            return redirect('admin/dashboard');
        } else {
            return redirect()->back()->with('error', "Please enter correct email and password");
        }
    }

    // Delivery rider login page
    public function login_rider()
    {
        if (Auth::check() && Auth::user()->is_delivery == 1) {
            return redirect('rider/dashboard');
        }

        return view('rider.auth.login');
    }

    // Handle delivery rider login
    public function auth_login_rider(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'is_delivery' => 1,
            'status' => 0,
            'is_delete' => 0
        ], $remember)) {
            return redirect('rider/dashboard');
        } else {
            return redirect()->back()->with('error', "Please enter correct email and password");
        }
    }

    // Logout delivery rider
    public function logout_rider()
    {
        Auth::logout();
        return redirect('/');
    }

    // Admin logout
    public function logout_admin()
    {
        Auth::logout();
        return redirect('/');
    }

    // Customer registration
    public function auth_login(Request $request)
    {
        $remember = !empty($request->is_remember) ? true : false;

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'status' => 0,
            'is_delete' => 0
        ], $remember)) {
            if (!empty(Auth::user()->email_verified_at)) {
                $json['status'] = true;
                $json['message'] = 'success';
            } else {
                $save = User::getSingle(Auth::user()->id);

                try {
                    Log::info('Attempting to send verification email to: ' . $save->email);
                    $this->sendVerificationEmail($save);
                    Log::info('Verification email sent successfully to: ' . $save->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send verification email to ' . $save->email . ': ' . $e->getMessage());
                }

                Auth::logout();
                $json['status'] = false;
                $json['message'] = 'your account is not verified, Please check your inbox and verify';
            }
        } else {
            $json['status'] = false;
            $json['message'] = 'Please enter correct email and password';
        }

        echo json_encode($json);
    }

    // Admin registration
    public function auth_register(Request $request)
    {
        $checkEmail = User::checkEmail($request->email);  // Corrected method
        if (empty($checkEmail)) {
            $save = new User;
            $save->name = trim($request->name);
            $save->last_name = trim($request->last_name);
            $save->email = trim($request->email);  // You should also store the email
            $save->password = Hash::make($request->password);
            $save->save();

            try {
                Log::info('Attempting to send registration email to: ' . $save->email);
                $this->sendVerificationEmail($save);
                Log::info('Registration email sent successfully to: ' . $save->email);
            } catch (\Exception $e) {
                Log::error('Failed to send registration email to ' . $save->email . ': ' . $e->getMessage());
            }


            $user_id = 1;
            $url = url('admin/customer/list');
            $message = "New Customer Registers #" . $request->name;

            NotificationModel::insertRecord($user_id, $url, $message);

            $json['status'] = true;
            $json['message'] = "Your account has been successfully created. Please verify your email address";
        } else {
            $json['status'] = false;
            $json['message'] = "Email already taken, please choose another email";
        }

        echo json_encode($json);
    }

    public function activate_email($id)
    {
        $id = base64_decode($id);
        $user = User::getSingle($id);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect(url(''))->with('success', "Email successfully verified");
    }

    public function forgot_password(Request $request)
    {
        $data['meta_title'] = "Forgot Password";
        return view('admin.auth.forgot', $data);
    }

    public function auth_forgot_password(Request $request)
    {
        // Validate the request input to ensure the email is valid
        $request->validate([
            'email' => 'required|email', // Removed the exists rule from validation
        ]);

        // Find the user based on the email
        $user = User::where('email', $request->email)->first(); // Get the first user with the provided email

        // Check if the user was found
        if ($user) {
            // Generate a random token for password reset
            $user->remember_token = Str::random(30);
            $user->save();

            // Send the ForgotPasswordMail to the user's email
            try {
                Mail::to($user->email)->send(new ForgotPasswordMail($user));
                Log::info('Password reset email sent successfully to: ' . $user->email);
            } catch (\Exception $e) {
                Log::error('Failed to send password reset email: ' . $e->getMessage());
                return redirect()->back()->with('error', "Unable to send password reset email. Please try again later.");
            }

            // Redirect back with a success message
            return redirect()->back()->with('success', "Password reset email has been sent.");
        } else {
            // Redirect back with an error message if email not found
            return redirect()->back()->with('error', "Email not found in the system.");
        }
    }

    public function reset($token)
    {
        $user = User::where('remember_token', '=', $token)->first();
        if (!empty($user)) {
            $data['user'] = $user;
            $data['meta_title'] = "Reset Password";
            return view('admin.auth.reset', $data);
        } else {
            abort(404);
        }
    }

    public function auth_reset($token, Request $request)
    {
        // Validate the input to ensure passwords are filled
        $request->validate([
            'password' => 'required|min:8', // Ensure password is at least 8 characters
            'cpassword' => 'required|same:password', // Ensure confirmation matches the password
        ]);

        // Find the user with the provided token
        $user = User::where('remember_token', '=', $token)->first();

        if ($user) {
            // If passwords match, hash the new password and reset the remember token
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30); // Change token to prevent reuse
            $user->save();

            return redirect(url(''))->with('success', "Password successfully reset.");
        } else {
            // If no user is found, redirect with an error message
            return redirect(url(''))->with('error', "Invalid token or user not found.");
        }
    }

    public function lockscreen()
    {
        return view('auth.lockscreen', ['user' => Auth::user()]);
    }

    private function sendVerificationEmail(User $user): void
    {
        $setting = \App\Models\SystemSettingModel::getSingle();
        $websiteName = $setting->website_name ?? config('app.name', 'HenzNoval');
        $supportEmail = $setting->email_one ?? config('mail.from.address');
        $verificationUrl = url('activate/'.base64_encode($user->id));
        $subject = $websiteName.' - Verify your email';
        $html = $this->verificationEmailHtml($user, $websiteName, $supportEmail, $verificationUrl);

        Mail::html($html, function ($message) use ($user, $subject) {
            $message->to($user->email, $user->name)->subject($subject);
        });
    }

    private function verificationEmailHtml(User $user, string $websiteName, string $supportEmail, string $verificationUrl): string
    {
        $safeName = e($user->name);
        $safeWebsiteName = e($websiteName);
        $safeSupportEmail = e($supportEmail);
        $safeVerificationUrl = e($verificationUrl);
        $year = date('Y');

        return <<<HTML
<!doctype html>
<html>
<body style="margin:0;padding:0;background:#f3f6fb;font-family:Arial,Helvetica,sans-serif;color:#172033;">
  <div style="max-width:640px;margin:0 auto;padding:28px 16px;">
    <div style="padding:10px 0 24px;letter-spacing:6px;font-size:12px;color:#7b8aa0;text-transform:uppercase;">
      <strong style="background:#ffe59a;color:#172033;padding:3px 7px;letter-spacing:4px;">{$safeWebsiteName}</strong>
      <span style="margin-left:12px;">Account Verification</span>
    </div>
    <div style="background:linear-gradient(135deg,#143b78,#3b82c4);color:#fff;padding:34px 38px;border-radius:18px 18px 0 0;">
      <h1 style="margin:0 0 10px;font-size:30px;line-height:1.2;color:#fff;">Verify your email</h1>
      <p style="margin:0;color:#d8e7fb;font-size:16px;">Complete your {$safeWebsiteName} registration.</p>
    </div>
    <div style="background:#fff;border:1px solid #e2e8f0;border-top:0;padding:34px 38px;border-radius:0 0 18px 18px;">
      <p style="font-size:18px;margin:0 0 16px;">Hi <strong>{$safeName}</strong>,</p>
      <p style="font-size:16px;line-height:1.7;color:#5f6f84;margin:0 0 28px;">
        Thanks for creating your {$safeWebsiteName} account. Please confirm that this email belongs to you so we can activate your account and keep your shopping experience secure.
      </p>
      <div style="text-align:center;margin:30px 0;">
        <a href="{$safeVerificationUrl}" style="display:inline-block;background:#2563eb;color:#fff;text-decoration:none;padding:14px 26px;border-radius:8px;font-weight:700;font-size:16px;">Verify Email Address</a>
      </div>
      <p style="font-size:14px;line-height:1.7;color:#8a97a8;margin:0 0 22px;">
        If the button does not open, copy and paste this link into your browser:<br>
        <a href="{$safeVerificationUrl}" style="color:#2563eb;">{$safeVerificationUrl}</a>
      </p>
      <div style="padding:18px;border:1px dashed #d8e0eb;border-radius:12px;background:#f8fafc;">
        <p style="margin:0;font-size:14px;line-height:1.7;color:#718096;">
          If you did not create this account, you can safely ignore this email. No account will be verified unless this link is opened.
        </p>
      </div>
    </div>
    <div style="margin-top:22px;padding:20px 24px;background:#edf2f7;color:#8a97a8;font-size:13px;border-radius:10px;">
      <div>
        <strong style="background:#ffe59a;color:#172033;padding:3px 7px;letter-spacing:3px;">{$safeWebsiteName}</strong>
        <a href="mailto:{$safeSupportEmail}" style="float:right;color:#2563eb;">{$safeSupportEmail}</a>
      </div>
      <p style="clear:both;margin:20px 0 0;text-align:center;">&copy; {$year} {$safeWebsiteName}. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
HTML;
    }

    public function unlock(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard'); // This now points to admin/dashboard
        }

        return back()->withErrors(['message' => 'Invalid credentials.']);
    }
}
