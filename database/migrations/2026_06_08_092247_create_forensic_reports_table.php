<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forensic_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            // 1. Case Information
            $table->string('case_reference_number')->unique();
            $table->string('investigation_title');
            $table->string('requesting_agency');
            $table->string('lead_examiner');
            $table->string('court_jurisdiction')->nullable();
            $table->date('date_of_examination');
            $table->string('status');
            $table->string('review_status');
 
            // 2. Declaration
            $table->text('certification_of_evidence_integrity')->nullable();
            $table->text('confirmation_of_methodologies')->nullable();
            $table->string('examiner_signature')->nullable();
            $table->date('signature_date')->nullable();
 
            // 3. Executive Summary
            $table->text('purpose_of_investigation')->nullable();
            $table->text('summary_of_findings')->nullable();
            $table->text('summary_of_conclusions')->nullable();
 
            // 4. Scope of Examination
            $table->text('devices_examined')->nullable();
            $table->text('evidence_sources')->nullable();
            $table->text('investigation_objectives')->nullable();
 
            // 5. Legal Authority
            $table->text('search_warrant_details')->nullable();
            $table->text('court_order_references')->nullable();
            $table->text('consent_authorization')->nullable();
            $table->text('applicable_legal_framework')->nullable();
 
            // 6. Evidence Received
            $table->text('evidence_inventory')->nullable();
            $table->text('condition_of_evidence')->nullable();
            $table->string('hash_algorithm')->default('SHA-256');
            $table->text('hash_verification_details')->nullable();
 
            // 7. Chain of Custody
            $table->text('evidence_transfer_records')->nullable();
            $table->text('storage_records')->nullable();
            $table->text('custodian_signatures')->nullable();
 
            // 8. Methodology
            $table->text('methodology_identification')->nullable();
            $table->text('methodology_preservation')->nullable();
            $table->text('methodology_acquisition')->nullable();
            $table->text('methodology_examination')->nullable();
            $table->text('methodology_analysis')->nullable();
            $table->text('methodology_reporting')->nullable();
 
            // 9. Forensic Environment
            $table->text('workstation_specifications')->nullable();
            $table->text('write_blockers_used')->nullable();
            $table->text('forensic_tools_and_versions')->nullable();
 
            // 10. Examination Procedures
            $table->text('imaging_procedures')->nullable();
            $table->text('verification_methods')->nullable();
            $table->text('artifact_analysis')->nullable();
            $table->text('timeline_reconstruction')->nullable();
 
            // 11. Findings and Analysis
            $table->text('user_activity_analysis')->nullable();
            $table->text('file_system_analysis')->nullable();
            $table->text('browser_history')->nullable();
            $table->text('email_analysis')->nullable();
            $table->text('usb_analysis')->nullable();
            $table->text('mobile_device_analysis')->nullable();
 
            // 12. Timeline of Events
            $table->text('chronological_reconstruction')->nullable();
            $table->text('correlation_of_evidence_sources')->nullable();
 
            // 13. Conclusion
            $table->text('investigation_conclusions')->nullable();
            $table->text('evidentiary_significance')->nullable();
 
            // 14. Expert Opinion
            $table->text('professional_opinion')->nullable();
            $table->text('reasonable_degree_of_forensic_certainty')->nullable();
 
            // 15. Limitations
            $table->text('scope_limitations')->nullable();
            $table->text('potential_data_gaps')->nullable();
            $table->text('timestamp_considerations')->nullable();
 
            // 16. Recommendations
            $table->text('security_improvements')->nullable();
            $table->text('further_investigative_actions')->nullable();
            $table->text('policy_recommendations')->nullable();
 
            // 17. Appendices
            $table->text('hash_values')->nullable();
            $table->text('screenshots')->nullable();          // JSON array of file paths
            $table->text('tool_logs')->nullable();
            $table->text('evidence_photographs')->nullable(); // JSON array of file paths
            $table->text('glossary_of_terms')->nullable();
 
            
            $table->timestamps();
            $table->softDeletes();
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forensic_reports');
    }
};
