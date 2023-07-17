<?php
class AdminLoginFilter extends Filter
{
    public function doFilter(string $url): void
    {
        if (!array_key_exists('adminObj', $_SESSION)) {
            $this->redirect('/vexepro/auth/login?redirectUrl=' . $url);
        }
    }
}
