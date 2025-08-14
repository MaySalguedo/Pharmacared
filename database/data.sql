USE pharmacared;

EXEC auth.create_account 
	@email = 'felipemaysalguedo@gmail.com',
	@password = 'lambda73',
	@name = 'Felipe May',
	@admin = 1,
	@picture = 'https://i.ytimg.com/vi/5NTVNPlr9t8/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBx665mKAA3lDcerYWp9xfPEcmyCQ';

INSERT INTO pharma.pharmaceutical (

	name, description, price, expiresat

) VALUES ('Aspirin', 'Pain reliever and anti-inflammatory medication', 5.99, '2025-12-31'),
('Ibuprofen', 'Nonsteroidal anti-inflammatory drug (NSAID)', 7.50, '2026-06-30'),
('Paracetamol', 'Acetaminophen pain and fever reducer', 4.25, '2025-09-15'),
('Amoxicillin', 'Penicillin-type antibiotic', 12.75, '2024-11-30'),
('Lisinopril', 'ACE inhibitor for hypertension', 9.99, '2026-03-31'),
('Atorvastatin', 'Cholesterol-lowering statin', 15.25, '2025-10-31'),
('Metformin', 'Oral diabetes medication', 8.49, '2026-01-15'),
('Levothyroxine', 'Thyroid hormone replacement', 11.30, '2025-08-31'),
('Omeprazole', 'Proton pump inhibitor for GERD', 14.75, '2026-02-28'),
('Albuterol', 'Bronchodilator for asthma', 18.99, '2024-12-31'),
('Simvastatin', 'HMG-CoA reductase inhibitor', 13.25, '2025-07-31'),
('Losartan', 'Angiotensin II receptor blocker', 10.50, '2026-04-30'),
('Gabapentin', 'Anticonvulsant for nerve pain', 7.89, '2025-05-31'),
('Hydrochlorothiazide', 'Thiazide diuretic', 6.25, '2024-10-31'),
('Metoprolol', 'Beta-blocker for heart conditions', 9.45, '2026-07-31'),
('Citalopram', 'SSRI antidepressant', 12.99, '2025-11-30'),
('Warfarin', 'Oral anticoagulant', 8.75, '2024-09-30'),
('Sertraline', 'Selective serotonin reuptake inhibitor', 11.20, '2026-05-31'),
('Pantoprazole', 'Proton pump inhibitor', 16.49, '2025-04-30'),
('Montelukast', 'Leukotriene receptor antagonist', 14.25, '2026-08-31');