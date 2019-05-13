<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class importMassCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'My import mass category';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (explode("\n",$this->data()) as $cat){
            $cat = trim($cat);
            $result = \App\Models\Categories::updateOrCreate(
                ['slug' => str_slug($cat)],
                [
                    'title' => $cat,
                    'meta_title' => $cat,
                    'meta_keywords' => $cat,
                    'meta_description' => $cat,
                ]
            );
            if($result) $this->info($cat);
            else $this->error($cat);
        }
    }

    public function data()
    {
        $data = "Accounting Software
Accounts Payable Software
Accounts Receivable Software
Affiliate Marketing Software
Agile Project Management Software
Applicant Tracking Software
Appointment Scheduling Software
Artificial Intelligence Software
Backup Software
Billing and Invoicing Software
Blog Software
Budgeting Software
Business Intelligence Software
Business Process Management Software
CAD Software
Call Center Software
Campaign Management Software
Church Management Software
Club Management Software
Collaboration Software
Collaboration Tools Software
Communications Software
Construction Management Software
Contact Management Software
Content Management Software
Content Marketing Software
Contract Lifecycle Management Software
Conversion Rate Optimization Software
Corporate LMS Software
CPQ Software
CRM Software
Customer Experience Management Software
Customer Service Software
Customer Support Software
Demand Generation Software
Dental Practice Management Software
Digital Asset Management Software
Document Creation Software
Document Management Software
Donor Management Software
E-Signature Software
eCommerce Software
EHR Software
EHS Software
Email Management Software
Email Marketing Software
Employee Monitoring Software
Employee Scheduling Software
Enterprise Project Management Software
Enterprise Social Networking Software
ERP Software
Event Management Software
Expenses Management Software
Feedback & Reviews Management Software
Field Service Management Software - FSM
File Sharing & Document Management Software
File Sharing Software
Financial Reporting Software
Fleet Management Software
Forms Automation Software
Freelance Platforms
Gamification Software
Geographic Information Systems - GIS
Grammar Checker Software
Graphic Design Software
Help Desk & Ticketing Software
Help Desk Software
Hotel Management Software
HR Software
Industry-Specific Help Desk Software
Instant Messaging & Chat Software
Inventory Management Software
IT Development Software
IT Management Software
IT Security Software
IT Service Management Software
Landing Page Software
Law Practice Management Software
Lead Management Software
Learning Management System - LMS
Live Chat Software
Maintenance Management Software - CMMS
Marketing Automation Software
Marketing Software
Medical Practice Management Software
Mobile Marketing Software
Mobile Payment Systems
Online Accounting Software
Online Booking Software
Online Community Software
Online CRM Software
Payment Gateway
Payroll Software
Performance Appraisal Software
POS Software
Procurement Software
Product Lifecycle Management Software - PLM
Productivity Suite Software
Professional Services Automation Software - PSA
Project Collaboration Software
Project Management Software
Project Portfolio Management Software - PPM
Remote Support Software
Reputation Management Software
Resource Management Software
Restaurant Management Software
Sales Automation Software
Sales Force Automation Software
Sales Management Software
Sales Proposal Automation Software
Sales Software
Salon Software
Search Marketing Software
SEO Software
Service Desk Software
Shopping Cart Software
Social Collaboration Software
Social CRM Software
Social Media Management Software
Social Media Monitoring Software
Survey Software
Talent Management Software
Task Management Software
Tax Software
Test Management Software
Time Management Software
Time Tracking Software
Translation Software
Video Conferencing Software
Video Editing Software
Visual Project Management Software
VoIP Software
VPN Services
Web Collaboration Software
Web Conferencing Software
Website Builder Software
Workflow Management Software";
        return $data;
    }
}
