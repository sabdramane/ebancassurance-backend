<div style="display: flex; align-items: center; width: 100%;">
    <img src="images/logo_coris_v.PNG" alt="Logo" style="margin-right: 10px;margin-top:-30px" />
    <p style="margin: 0; flex-grow: 1; text-align: right;margin-top:-20px;font-size:12px">
        2023-04/MEFP/SG/DGTCP/DA/CORIS-VIE</p>
</div>
<div style="background-color:darkgray;margin-top:-10px">
    <h4 style="text-align: center">ATTESTATION D'ASSURANCE N° {{$contrat->numprojet}}</h4>
</div>
<div style="margin-top: -20px">
    <p style="margin-top: -2px;text-align:center"> Banque : <span
            style="font-weight: bold">{{ $contrat->banque->libebanque}}</span></p>
</div>
<div style="margin-top: -30px">
    <p> Agence : <span style="font-weight: bold">{{ $contrat->agence->libeagence}}</span>
        <span style="margin-left:100px">
            Agent : <span style="font-weight: bold">{{ $contrat->user->name}}</span>
        </span>
    </p>
    <br>
</div>
<div style="margin-top:-35px;border: 1px solid">
    <div style="background-color:darkgray;border: 1px solid">
        <h4 style="text-align: center;margin:0px">I. JE SOUSCRIS AU CONTRAT FLEX EMPRUNTEUR </h4>
    </div>
    <div>
        <table style="margin-top: 0px;font-size:12px">
            <tr>
                <td style="width: 150px">
                    N° CNI :
                </td>
                <td style="width: 200px">
                    {{ $contrat->client->numcompte}}
                </td>
                <td style="width: 150px">
                    Civilité :
                </td>
                <td style="width: 100px">
                    {{ $contrat->client->civilite}}
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Nom :
                </td>
                <td style="width: 200px" colspan="2">
                    {{ $contrat->client->nom}}
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Prénom (s) :
                </td>
                <td style="width: 200px" colspan="2">
                    {{ $contrat->client->prenom}}
                </td>
                <td>

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Date de naissance :
                </td>
                <td style="width: 200px">
                    {{ $contrat->client->dateNaissance}}
                </td>
                <td style="width: 150px">
                    Lieu :
                </td>
                <td style="width: 100px">
                    {{ $contrat->client->lieuNaissance}}
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Profession :
                </td>
                <td style="width: 200px">
                    {{ $contrat->client->profession}}
                </td>
                <td style="width: 150px">
                    Personne à prévenir :
                </td>
                <td style="width: 200px">
                    {{ $contrat->client->person_nom}} {{ $contrat->client->person_prenom}}
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Téléphone :
                </td>
                <td style="width: 200px">
                    {{ $contrat->client->telephone}}
                </td>
                <td style="width: 150px">
                    Contact personne à prévenir
                </td>
                <td style="width: 100px">
                    {{ $contrat->client->person_tel}}
                </td>
            </tr>
        </table>
    </div>
</div>
<div style="margin-top:5px;border: 1px solid">
    <div style="background-color:darkgray;border: 1px solid">
        <h4 style="text-align: center;margin:0px">II. CARACTERISTIQUES DU PRÊT </h4>
    </div>
    <div>
        <table style="margin-top: 0px;font-size:12px">
            <tr>
                <td style="width: 150px">
                    Montant du crédit :
                </td>
                <td style="width: 200px">
                    {{ formatPrixBf($contrat->montantpret) }}
                </td>
                <td style="width: 150px">
                    Durée totale du crédit :
                </td>
                <td style="width: 100px">
                    {{ $contrat->duree_pret}} mois
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Nombre de remboursements :
                </td>
                <td style="width: 200px">
                    {{ $contrat->duree_amort}}
                </td>
                <td style="width: 150px">
                    Durée du différé:
                </td>
                <td style="width: 200px">
                    {{ $contrat->differe}} mois
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Nature du crédit (s) :
                </td>
                <td style="width: 200px">
                    {{ $contrat->type_pret}}
                </td>
                <td>
                    Date de la 1ère échéance :
                </td>
                <td>
                    {{ $contrat->dateeffet}}
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Périodicité de remboursement :
                </td>
                <td style="width: 200px">
                    {{ $contrat->periodicite}}
                </td>
                <td style="width: 150px">
                    Date de la dernière échéance :
                </td>
                <td style="width: 100px">
                    {{ $contrat->dateeche}}
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Capital de prévoyance :
                </td>
                <td style="width: 200px">
                    {{ formatPrixBf($contrat->capitalprevoyance) }}
                </td>
                <td style="width: 150px">
                    Beogo :
                </td>
                <td style="width: 100px">
                    @if ($contrat->beogo == 0)
                        NON
                    @else
                        OUI
                    @endif
                </td>
            </tr>
            <tr>
                <td style="width: 160px">
                    Perte d'emploi :
                </td>
                <td style="width: 200px">
                    @if ($contrat->prime_perte_emploi == 0)
                        NON
                    @else
                        OUI
                    @endif
                </td>
                <td style="width: 160px">
                    Montant de la traite :
                </td>
                <td style="width: 200px">
                    {{ formatPrixBf($contrat->montant_traite) }}
                </td>
            </tr>
        </table>
    </div>
</div>
<div style="margin-top:5px;border: 1px solid">
    <div style="background-color:darkgray;border: 1px solid">
        <h4 style="text-align: center;margin:0px">III. DECLARATION DE SANTE </h4>
    </div>
    <div>
        <table style="margin-top: 0px;font-size:12px">
            <tr>
                <td style="width: 150px">
                    Quelle est votre taille (cm) :
                </td>
                <td style="width: 200px">
                    @if ($contrat_quest_tailles != null)
                        {{ $contrat_quest_tailles->valeur }}
                    @endif

                </td>
                <td style="width: 150px">
                    Quel est votre (Kg) :
                </td>
                <td style="width: 100px">
                    @if ($contrat_quest_poids != null)
                        {{ $contrat_quest_poids->valeur }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div>
        <table style="margin-top: 0px;font-size:12px;border: 1px solid black;border-collapse: collapse;">
            <tr>
                <td style="width: 300px;color:white">
                    QUESTIONS
                </td>
                <td style="width: 92px;border: 1px solid black;text-align:center;border-collapse: collapse;">
                    REPONSE
                </td>
                <td style="width: 300px;border: 1px solid black;text-align:center;border-collapse: collapse;">
                    PRECISIONS
                </td>
            </tr>
            @foreach ($contrat_quests as $quest)
                <tr>
                    <td style="width: 300px;border: 1px solid black;border-collapse: collapse;">
                        {{ $quest->libelle}}
                    </td>
                    <td style="width: 92px;border: 1px solid black;border-collapse: collapse;text-align:center">
                        @if ($quest->valeur == 'false')
                            NON
                        @else
                            OUI
                        @endif
                    </td>
                    <td style="width: 300px;border: 1px solid black;border-collapse: collapse;">
                        {{ $quest->motif}}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div style="margin-top:10px;border: 1px solid">
    <div style="background-color:darkgray;border: 1px solid">
        <h4 style="text-align: center;margin:0px">III. VALIDATION </h4>
    </div>
    <div>
        <table style="margin-top: 0px;font-size:12px">
            <tr>
                <td style="width: 150px">
                    Prime crédit :
                </td>
                <td style="width: 200px">
                    {{ formatPrixBf($contrat->prime_nette_flex) }}
                </td>
                <td style="width: 150px">
                    Prime différé :
                </td>
                <td style="width: 100px">

                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Prime prévoyance :
                </td>
                <td style="width: 200px">
                    @if ($contrat->prime_nette_prevoyance != 0)
                        {{ formatPrixBf($contrat->prime_nette_prevoyance) }}
                    @endif
                </td>
                <td style="width: 150px">
                    Prime Béogo:
                </td>
                <td style="width: 200px">
                    @if ($contrat->prime_beogo != 0)
                        {{ formatPrixBf($contrat->prime_beogo) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td style="width: 150px">
                    Prime perte d'emploi :
                </td>
                <td style="width: 200px">
                    @if ($contrat->prime_perte_emploi != 0)
                        {{ formatPrixBf($contrat->prime_perte_emploi) }}
                    @endif
                </td>
                <td>
                    Coût de Police :
                </td>
                <td>
                    {{ formatPrixBf($contrat->cout_police) }}
                </td>
            </tr>
            <tr>
                <td style="width: 150px;font-weight:bold">
                    Prime totale :
                </td>
                <td style="width: 200px;font-weight:bold">
                    {{ formatPrixBf($contrat->primetotale) }}
                </td>
            </tr>
        </table>
    </div>
</div>
<div style="margin-top:-20px">
    <h4 style="text-align:right;font-weight:12px">Fait à Ouagadougou, le <span> {{ $contrat->datesaisie }}</span> </h4>
</div>
<div
    style="display: flex; justify-content: space-between; align-items: center; width: 100%; border: 1px solid transparent;margin-top:-25px">
    <div style="flex: 1; text-align: left;margin-top:0px">
        <h4 style="margin: 0;">Signature de l'assuré</h4>
        <span style="font-size: 10px;font-style:italic">Signature précédée de la mention manuscrite "Lu et
            Approuvé"</span>
    </div>
    <div style="flex: 1; text-align: right;margin-top:-30px">
        <h4 style="margin: 0;">Signature Agence</h4>
    </div>
</div>
<div style="margin-top:80px">
    <hr>
    <h6 style="text-align: center;margin-top:-5px">Coris Assurances Vie Burkina</h6>
    <h6 style="text-align: center;margin-top:-25px">Entreprise régie par le code des Assurances, Société anonyme avec
        Conseil d'administration au capital de 5 000 000 FCFA entièrement libéré</h6>
    <h6 style="text-align: center;margin-top:-25px">RCCM: BF OUA 2021 B 13161 - IFU 00053466L - Siège social : 981,
        Avenue LOUDUN, Immeuble Coris Bourse, 01 BP 6092 Ouagadougou 01</h6>
    <h6 style="text-align: center;margin-top:-25px">Tél: 25 39 18 98/Fax: 25 33 22 54 - Compte N° 19338424101-65 Coris
        Bank International - www.coris-assurances.com-</h6>
</div>