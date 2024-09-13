import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import { Subscription, Payment } from '@/types';
import Table from '@/Components/Table/Table';

const Index = () => {
  const { subscriptions, lastPayment, isConnected } = usePage<{
    subscriptions: Subscription[];
    lastPayment: Payment,
    isConnected: boolean }>().props;

	console.log('[lastPayment]', lastPayment)

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">User Stripe Subscription</h1>

      {
        !isConnected &&
        (
          <div className="flex items-center justify-between mb-6">
            <Link
              href={route('stripe.createcustomer')}
              className="btn-indigo focus:outline-none"
            >
              <span>Connect to Stripe</span>
            </Link>
          </div>
        )
      }

      {
        isConnected &&
        (
          <>
            <h2 className="mb-4 text-xl font-bold">Subscriptions</h2>
            <Table
              columns={[
                { label: 'Status', name: 'status' },
                { label: 'Plan', name: 'plan.nickname' },
                { label: 'Current Period End', name: 'current_period_end',
                  renderCell: row => (
                    <span>{new Date(row.current_period_end * 1000).toLocaleDateString()}</span>
                  )
                }
              ]}
              rows={subscriptions}
            />
            {
              lastPayment &&
              <>
                <h2 className="my-4 text-xl font-bold">Last Payment</h2>
                <Table
                  columns={[
                    { label: 'Date', name: 'created',
                      renderCell: row => (
                        <span>{new Date(row.created * 1000).toLocaleDateString()}</span>
                      )
                    },
                    { label: 'Amount', name: 'amount',
                      renderCell: row => (
                        <span>{row.amount / 100}</span>
                      )
                     },
                    { label: 'Status', name: 'status' },
                  ]}
                  rows={[lastPayment]}
                />
              </>
            }
          </>
        )
      }

    </div>
  );
};

Index.layout = (page: React.ReactNode) => (
  <MainLayout title="Calendars" children={page} />
);

export default Index;
