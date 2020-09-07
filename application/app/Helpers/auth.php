<?php
/* ----------Custom password login---------- */
function authAttempt(array $credentials)
{
    $candidate = Candidate::where('email', $credentials['email'])->first();
    if (isset($candidate)) {
        if ($candidate->password == base64_encode($credentials['password'])) {
            return auth()->guard('candidates')->loginUsingId($candidate->id);
        }
    }
    return false;
}
