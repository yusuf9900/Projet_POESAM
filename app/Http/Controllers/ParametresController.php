<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParametresController extends Controller
{
    /**
     * Afficher la page des paramètres
     */
    public function index()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page');
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('home');
        }
        
        return view('parametres.index', compact('user'));
    }
    
    /**
     * Mettre à jour les informations du profil
     */
    public function updateProfile(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('home');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$userId,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bio = $request->bio;
        
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->avatar && !Str::contains($user->avatar, 'default-avatar')) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatar = $request->file('avatar');
            $fileName = time() . '_' . $userId . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('avatars', $fileName, 'public');
            $user->avatar = $path;
        }
        
        $user->save();
        
        // Mettre à jour les cookies si nécessaire
        if (isset($_COOKIE['user_name']) && $_COOKIE['user_name'] !== $user->name) {
            setcookie('user_name', $user->name, time() + (86400 * 30), '/');
        }
        
        return redirect()->route('parametres.index')->with('success', 'Profil mis à jour avec succès');
    }
    
    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('home');
        }
        
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Vérifier que le mot de passe actuel est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('parametres.index')->with('success', 'Mot de passe mis à jour avec succès');
    }
    
    /**
     * Mettre à jour les préférences de notification
     */
    public function updateNotifications(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('home');
        }
        
        $user->notification_email = $request->has('notification_email');
        $user->notification_evenements = $request->has('notification_evenements');
        $user->notification_messages = $request->has('notification_messages');
        $user->notification_communaute = $request->has('notification_communaute');
        
        $user->save();
        
        return redirect()->route('parametres.index')->with('success', 'Préférences de notification mises à jour');
    }
    
    /**
     * Mettre à jour les préférences de confidentialité
     */
    public function updatePrivacy(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('home');
        }
        
        $user->profil_public = $request->has('profil_public');
        $user->masquer_activite = $request->has('masquer_activite');
        $user->masquer_participation = $request->has('masquer_participation');
        
        $user->save();
        
        return redirect()->route('parametres.index')->with('success', 'Paramètres de confidentialité mis à jour');
    }
    
    /**
     * Supprimer le compte utilisateur
     */
    public function deleteAccount(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('home');
        }
        
        $request->validate([
            'password' => 'required|string',
        ]);
        
        // Vérifier que le mot de passe est correct
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Le mot de passe est incorrect']);
        }
        
        // Supprimer l'avatar
        if ($user->avatar && !Str::contains($user->avatar, 'default-avatar')) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        // Supprimer l'utilisateur
        $user->delete();
        
        // Supprimer les cookies d'authentification
        setcookie('is_logged_in', '', time() - 3600, '/');
        setcookie('user_id', '', time() - 3600, '/');
        setcookie('user_email', '', time() - 3600, '/');
        setcookie('user_name', '', time() - 3600, '/');
        setcookie('user_type', '', time() - 3600, '/');
        
        // Vider la session
        session()->flush();
        
        return redirect()->route('welcome')->with('success', 'Votre compte a été supprimé avec succès');
    }
}
