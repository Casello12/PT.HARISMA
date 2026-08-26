# Database Schema - Sistem Informasi Manajemen Stok dan Distribusi Produk Kosmetik
# PT. Kharisma Sukses Persada

## Phase 2: ERD dan Database Schema

### 2.1 Database Schema Overview

**Core Tables:**
1. **users** - User management dengan role
2. **roles** - Role definitions (Customer, Sales, Admin, Admin Gudang, Finance)
3. **permissions** - Permission definitions
4. **model_has_permissions** - User-Permission relationships
5. **model_has_roles** - User-Role relationships
6. **role_has_permissions** - Role-Permission relationships

**Master Data:**
7. **customers** - Customer data
8. **sales** - Sales staff data
9. **categories** - Product categories
10. **brands** - Product brands
11. **suppliers** - Supplier data
12. **warehouses** - Warehouse locations
13. **products** - Product master data

**Inventory:**
14. **warehouse_stocks** - Stock per warehouse
15. **stock_movements** - Stock transaction history
16. **stock_opnames** - Stock opname records
17. **stock_opname_items** - Stock opname detail items
18. **stock_transfers** - Stock transfer between warehouses
19. **stock_transfer_items** - Stock transfer detail items

**Transactions:**
20. **sales_orders** - Sales order header
21. **sales_order_items** - Sales order detail items
22. **order_status_histories** - Order status tracking
23. **invoices** - Invoice header
24. **invoice_items** - Invoice detail items
25. **payments** - Payment records
26. **payment_confirmations** - Payment verification records
27. **receivables** - Accounts receivable tracking

**Distribution:**
28. **shipments** - Shipment header
29. **shipment_items** - Shipment detail items
30. **shipment_trackings** - Shipment tracking history
31. **surat_jalan** - Delivery note records

**Automation & System:**
32. **payment_reminders** - Payment reminder history
33. **notifications** - User notifications
34. **audit_logs** - System audit logs
35. **system_settings** - System configuration

### 2.2 Table Relationships

```
users (1) --- (N) model_has_roles --- (N) roles
users (1) --- (N) model_has_permissions --- (N) permissions
roles (1) --- (N) role_has_permissions --- (N) permissions

customers (1) --- (N) sales_orders
sales (1) --- (N) sales_orders
sales (1) --- (N) customers

categories (1) --- (N) products
brands (1) --- (N) products
suppliers (1) --- (N) products

warehouses (1) --- (N) warehouse_stocks
products (1) --- (N) warehouse_stocks
products (1) --- (N) stock_movements
warehouses (1) --- (N) stock_movements

sales_orders (1) --- (N) sales_order_items
sales_orders (1) --- (N) order_status_histories
sales_orders (1) --- (1) invoices
invoices (1) --- (N) invoice_items
invoices (1) --- (N) payments
invoices (1) --- (1) receivables

shipments (1) --- (N) shipment_items
shipments (1) --- (N) shipment_trackings
sales_orders (1) --- (1) shipments

stock_transfers (1) --- (N) stock_transfer_items
warehouses (1) --- (N) stock_transfers (as origin)
warehouses (1) --- (N) stock_transfers (as destination)
```

### 2.3 Auto-Generated Number Formats

- Sales Order: SO-YYYYMMDD-XXXX
- Invoice: INV-YYYYMMDD-XXXX
- Shipment: SHP-YYYYMMDD-XXXX
- Payment: PAY-YYYYMMDD-XXXX
- Stock Movement: STM-YYYYMMDD-XXXX

### 2.4 Status Enums

**Order Status:**
- draft
- pending_confirmation
- confirmed
- awaiting_payment
- payment_verified
- processing
- packing
- ready_to_ship
- shipped
- in_transit
- delivered
- completed
- cancelled

**Payment Status:**
- unpaid
- awaiting_verification
- partially_paid
- paid
- overdue
- rejected

**Shipment Status:**
- awaiting_pickup
- processing
- picked_up
- in_transit
- at_hub
- out_for_delivery
- delivered
- failed

**Stock Movement Types:**
- in
- out
- return
- adjustment
- transfer
- opname

### 2.5 System Configuration

**Payment Reminder Settings:**
- Reminder H-7
- Reminder H-3
- Reminder H-1
- Reminder H+1 (overdue)
- Reminder H+3 (overdue follow-up)

**Company Settings:**
- Company Name: PT. Kharisma Sukses Persada
- Address, Email, Phone, WhatsApp
- Tax configuration
- Payment terms
- Minimum stock threshold
- Shipping configuration