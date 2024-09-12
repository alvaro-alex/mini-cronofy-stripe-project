import React from 'react';

interface LogoProps extends React.SVGProps<SVGSVGElement> {
  //
}

export default function Logo(props: LogoProps) {
  return (
    <img
        src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"
        width="400"
        alt="Laravel Logo"
    />
  );
}
