import { Link } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

function DashboardPage() {
  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">Dashboard</h1>
      <p className="mb-12 leading-normal">
        Hey there! Welcome to this platform, an app designed to help illustrate
        how Laravel works with
        <a
          className="mx-1 text-indigo-600 underline hover:text-orange-500"
          href="https://www.cronofy.com/"
        >
          Cronofy
        </a>
        and
        <a
          className="ml-1 text-indigo-600 underline hover:text-orange-500"
          href="https://stripe.com/"
        >
          Stripe
        </a>
        .
      </p>
      <div>
        <Link className="mr-1 btn-indigo" href="/cronofy/calendars">
          Cronofy
        </Link>
        <Link className="btn-indigo" href="/stripe/subscription">
          Stripe
        </Link>
      </div>
    </div>
  );
}

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
DashboardPage.layout = (page: React.ReactNode) => (
  <MainLayout title="Dashboard" children={page} />
);

export default DashboardPage;
